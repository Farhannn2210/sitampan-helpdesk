<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\LaporanMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function mahasiswaIndex()
    {
        $laporans = Laporan::with('messages')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('mahasiswa_dashboard', compact('laporans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subjek' => 'required|string|max:255',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'lampiran' => 'nullable|image|mimes:jpg,png,jpeg|max:10240', // Limit 10MB
        ]);

        $path = null;
        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('lampiran-laporan', 'public');
        }

        $laporan = Laporan::create([
            'user_id' => Auth::id(),
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

    public function adminIndex(Request $request)
    {
        $query = Laporan::with(['user', 'messages']);

        // REVISI: Logic Filter Status
        if ($request->has('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $laporans = $query->latest()->get();
        return view('dashboard', compact('laporans'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $laporan->update(['status' => $request->status]);
        return redirect()->route('admin.dashboard')->with('success', 'Status berhasil diperbarui!');
    }

    public function adminSendMessage(Request $request, Laporan $laporan)
    {
        $validated = $request->validate(['message' => 'required|string']);
        
        LaporanMessage::create([
            'laporan_id' => $laporan->id,
            'sender' => 'admin',
            'message' => $validated['message'],
            'source' => 'manual',
        ]);

        // Opsional: Update status jadi diproses jika sebelumnya 'baru'
        if($laporan->status === 'baru'){
            $laporan->update(['status' => 'diproses']);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Tanggapan berhasil dikirim!');
    }

    public function mahasiswaSendMessage(Request $request, Laporan $laporan)
    {
        $validated = $request->validate(['message' => 'required|string']);
        
        LaporanMessage::create([
            'laporan_id' => $laporan->id,
            'sender' => 'mahasiswa',
            'message' => $validated['message'],
        ]);

        return redirect()->route('mahasiswa.riwayat')->with('success', 'Pesan balasan terkirim!');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Laporan telah dihapus.');
    }

    public function generateResponAi(Request $request, Laporan $laporan)
    {
        @set_time_limit(120);
        $apiKey = $_ENV['OPENROUTER_API_KEY'] ?? env('OPENROUTER_API_KEY');
        $model = 'google/gemini-2.0-flash-exp:free';

        if (!$apiKey) return redirect()->back()->with('error', 'API Key belum dipasang!');

        try {
            $response = Http::withoutVerifying()->timeout(60)->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'Kamu adalah admin helpdesk SITAMPAN UNTAD. Jawab ramah & solutif.'],
                    ['role' => 'user', 'content' => "Subjek: {$laporan->subjek}\nDeskripsi: {$laporan->deskripsi}"],
                ],
            ]);

            $data = $response->json();

            if ($response->successful()) {
                $aiContent = trim(data_get($data, 'choices.0.message.content'));
                LaporanMessage::create([
                    'laporan_id' => $laporan->id,
                    'sender' => 'admin',
                    'message' => $aiContent,
                    'source' => 'ai',
                ]);
                $laporan->update(['status' => 'diproses']);
                return redirect()->back()->with('success', 'AI berhasil membalas!');
            }
            return redirect()->back()->with('error', 'Gagal memanggil AI: ' . ($data['error']['message'] ?? 'Server Sibuk'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Koneksi Gagal: ' . $e->getMessage());
        }
    }
}