<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\LaporanMessage;
use Illuminate\Support\Facades\Http;

class LaporanController extends Controller
{
    /**
     * Simpan laporan dari form
     */
    public function store(Request $request)
    {
        $path = null;

        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('lampiran-laporan', 'public');
        }

        $laporan = Laporan::create([
            'kategori' => $request->kategori,
            'subjek' => $request->subjek,
            'deskripsi' => $request->deskripsi,
            'lampiran' => $path,
            'status' => 'baru',
        ]);

        LaporanMessage::create([
            'laporan_id' => $laporan->id,
            'sender' => 'mahasiswa',
            'message' => $request->deskripsi,
            'source' => 'manual',
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Tampilkan laporan di dashboard admin
     */
    public function adminIndex()
    {
        $laporans = Laporan::with(['user', 'messages'])->latest()->get();
        return view('dashboard', compact('laporans'));
    }

    /**
     * Tampilkan laporan di dashboard mahasiswa
     */
    public function mahasiswaIndex()
    {
        $laporans = Laporan::with('messages')->latest()->get();
        return view('mahasiswa_dashboard', compact('laporans'));
    }

    /**
     * Update status laporan
     */
    public function updateStatus(Request $request, Laporan $laporan)
    {
        $laporan->update([
            'status' => $request->status,
        ]);
        
        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }

    /**
     * Hapus laporan
     */
    public function destroy(Laporan $laporan)
    {
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus');
    }

    /**
     * Admin: simpan respon manual/AI ke laporan
     */
    public function updateRespon(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'respon_admin' => ['required', 'string'],
            'respon_admin_sumber' => ['nullable', 'string', 'in:manual,ai'],
        ]);

        LaporanMessage::create([
            'laporan_id' => $laporan->id,
            'sender' => 'admin',
            'message' => $validated['respon_admin'],
            'source' => $validated['respon_admin_sumber'] ?? 'manual',
        ]);

        // Keep latest response mirrored in laporans table for backward compatibility.
        $laporan->update([
            'respon_admin' => $validated['respon_admin'],
            'respon_admin_sumber' => $validated['respon_admin_sumber'] ?? 'manual',
            'respon_admin_pada' => now(),
        ]);

        return redirect()->back()->with('success', 'Respon admin berhasil disimpan');
    }

    /**
     * Mahasiswa: kirim pesan lanjutan pada laporan (seperti chat)
     */
    public function mahasiswaSendMessage(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'message' => ['required', 'string'],
        ]);

        LaporanMessage::create([
            'laporan_id' => $laporan->id,
            'sender' => 'mahasiswa',
            'message' => $validated['message'],
            'source' => 'manual',
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim');
    }

    /**
     * Admin: generate respon berbasis AI (OpenRouter)
     */
    public function generateResponAi(Request $request, Laporan $laporan)
    {
        // Some Windows/PHP setups default max_execution_time=30; allow this endpoint to run longer.
        @set_time_limit(120);

        $apiKey = config('services.openrouter.api_key');
        $baseUrl = rtrim((string) config('services.openrouter.base_url'), '/');
        $model = (string) config('services.openrouter.model');
        $verifyTls = (bool) config('services.openrouter.verify_tls', true);
        $timeout = (int) config('services.openrouter.timeout', 90);
        $connectTimeout = (int) config('services.openrouter.connect_timeout', 15);
        $retries = (int) config('services.openrouter.retries', 1);

        if (!$apiKey) {
            return response()->json([
                'message' => 'OPENROUTER_API_KEY belum di-set di .env',
            ], 422);
        }

        $system = "Kamu adalah admin helpdesk kampus. Tulis respon yang sopan, jelas, ringkas, dan solutif dalam Bahasa Indonesia.\n"
            ."- Jangan menyebutkan bahwa kamu AI.\n"
            ."- Jika info kurang, minta detail yang diperlukan.\n"
            ."- Sertakan langkah tindak lanjut yang realistis.";

        $detailAduan = "Kategori: {$laporan->kategori}\n"
            ."Subjek: {$laporan->subjek}\n"
            ."Status saat ini: {$laporan->status}\n"
            ."Tanggal masuk: ".$laporan->created_at?->format('d M Y H:i')."\n"
            ."Deskripsi detail: {$laporan->deskripsi}\n";

        $user = "Buat respon untuk aduan mahasiswa berikut (gunakan detail ini sebagai konteks utama):\n".$detailAduan;

        $headers = [
            'Authorization' => 'Bearer '.$apiKey,
            'Content-Type' => 'application/json',
        ];

        $appUrl = (string) config('services.openrouter.app_url');
        $appName = (string) config('services.openrouter.app_name');
        if ($appUrl !== '') {
            $headers['HTTP-Referer'] = $appUrl;
        }
        if ($appName !== '') {
            $headers['X-Title'] = $appName;
        }

        $payload = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => $user],
            ],
            'temperature' => 0.4,
        ];

        $endpoint = $baseUrl;
        if (!str_ends_with($endpoint, '/chat/completions')) {
            $endpoint .= '/chat/completions';
        }

        try {
            $res = Http::timeout($timeout)
                ->connectTimeout($connectTimeout)
                ->retry(max(0, $retries), 250)
                ->withHeaders($headers)
                ->withOptions(['verify' => $verifyTls])
                ->post($endpoint, $payload);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'message' => 'Gagal menghubungi OpenRouter',
                'detail' => $e->getMessage(),
                'hint' => 'Jika timeout, naikkan OPENROUTER_TIMEOUT (mis. 120). Jika error SSL (cURL error 60), set OPENROUTER_VERIFY_TLS=false atau perbaiki CA certificate PHP/cURL.',
            ], 502);
        }

        if (!$res->successful()) {
            return response()->json([
                'message' => 'OpenRouter error',
                'status' => $res->status(),
                'body' => $res->json(),
            ], 502);
        }

        $content = data_get($res->json(), 'choices.0.message.content');
        if (!is_string($content) || trim($content) === '') {
            return response()->json([
                'message' => 'OpenRouter tidak mengembalikan konten respon',
            ], 502);
        }

        return response()->json([
            'respon' => trim($content),
            'model' => $model,
        ]);
    }
}
