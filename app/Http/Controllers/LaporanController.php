<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

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

        Laporan::create([
            'kategori' => $request->kategori,
            'subjek' => $request->subjek,
            'deskripsi' => $request->deskripsi,
            'lampiran' => $path,
            'status' => 'baru',
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Tampilkan laporan di dashboard admin
     */
    public function adminIndex()
    {
        $laporans = Laporan::with('user')->latest()->get();
        return view('dashboard', compact('laporans'));
    }

    /**
     * Tampilkan laporan di dashboard mahasiswa
     */
    public function mahasiswaIndex()
    {
        $laporans = Laporan::latest()->get();
        return view('mahasiswa_dashboard', compact('laporans'));
    }

    /**
     * Update status laporan
     */
    public function updateStatus(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => $request->status,
        ]);
        
        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }

    /**
     * Hapus laporan
     */
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus');
    }
}
