<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\LaporanMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function mahasiswaIndex()
    {
        $laporans = Laporan::with(['messages' => function($q) {
                $q->orderBy('created_at', 'asc');
            }])
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
            'lampiran' => 'nullable|image|mimes:jpg,png,jpeg|max:10240', 
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
        if($laporan->status === 'baru') $laporan->update(['status' => 'diproses']);
        return redirect()->route('admin.dashboard')->with('success', 'Tanggapan berhasil dikirim!');
    }

    public function mahasiswaSendMessage(Request $request, Laporan $laporan)
    {
        // KEAMANAN: Cek apakah laporan ini milik mahasiswa yang login
        if ($laporan->user_id !== Auth::id()) abort(403, 'Akses ilegal!');
        
        $validated = $request->validate(['message' => 'required|string']);
        LaporanMessage::create([
            'laporan_id' => $laporan->id,
            'sender' => 'mahasiswa',
            'message' => $validated['message'],
            'source' => 'manual',
        ]);
        return redirect()->back()->with('success', 'Pesan balasan terkirim!');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Laporan telah dihapus.');
    }

    public function cetakPdf(Laporan $laporan)
    {
        // KEAMANAN: Hanya admin atau pemilik laporan yang boleh cetak
        if (Auth::user()->role !== 'admin' && $laporan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak punya izin mencetak laporan ini!');
        }

        $laporan->load(['messages' => function($q) {
            $q->orderBy('created_at', 'asc');
        }, 'user']);

        $pdf = Pdf::loadView('cetak_laporan', compact('laporan'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-SITAMPAN-'.$laporan->id.'.pdf');
    }

    public function generateResponAi(Request $request, Laporan $laporan)
    {
        @set_time_limit(180);
        
        // Membaca API Key langsung dari file .env (Sangat Aman)
        $apiKey = env('OPENROUTER_API_KEY');
        
        // Memakai model Gemini 2.0 Flash (Super Cepat & Stabil)
        $model = 'openrouter/free';
        $baseUrl = 'https://openrouter.ai/api/v1';
        
        if (empty($apiKey)) {
            return redirect()->back()->with('error', 'Waduh, API Key belum dipasang di file .env Bang!');
        }

        try {
            $response = Http::timeout(60)
                ->connectTimeout(15)
                ->withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                    'HTTP-Referer' => env('APP_URL', 'http://localhost'),
                    'X-Title' => 'SITAMPAN UNTAD',
                ])
                ->post($baseUrl . '/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => "Kamu adalah admin helpdesk SITAMPAN UNTAD. Jawab ramah, empati, singkat, dan berikan solusi langsung. Gunakan poin-poin '-' untuk langkah-langkah."],
                        ['role' => 'user', 'content' => "Kategori: {$laporan->kategori}\nSubjek: {$laporan->subjek}\nDeskripsi: {$laporan->deskripsi}"]
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiContent = trim(data_get($data, 'choices.0.message.content'));
                
                if(!empty($aiContent)) {
                    LaporanMessage::create([
                        'laporan_id' => $laporan->id,
                        'sender' => 'admin',
                        'message' => $aiContent,
                        'source' => 'ai',
                    ]);
                    if($laporan->status === 'baru') $laporan->update(['status' => 'diproses']);
                    return redirect()->back()->with('success', 'AI Gemini berhasil membalas!');
                }
            }
            
            // Tangkap pesan error kalau OpenRouter lagi bermasalah (Anti Silent Fail)
            $errorMsg = $response->json('error.message') ?? 'Server AI sedang sibuk Bang.';
            return redirect()->back()->with('error', 'Gagal: ' . $errorMsg);

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Koneksi Putus: ' . $e->getMessage());
        }
    }
}