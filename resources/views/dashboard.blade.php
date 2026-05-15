<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Sora:wght@400;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
        .glass { background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-[#F8FAFC]" x-data="{ open: false }">

    <div x-show="open" class="fixed inset-y-0 left-0 w-80 glass text-white z-50 shadow-2xl flex flex-col border-r border-white/5">
        <div class="p-8 flex justify-between items-center border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center"><i data-lucide="shield-check" class="text-white"></i></div>
                <div><span class="font-sora font-extrabold text-xl block leading-none tracking-tighter">SITAMPAN</span></div>
            </div>
            <button @click="open = false" class="p-2 hover:bg-white/10 rounded-full transition"><i data-lucide="chevron-left" class="w-5 h-5 text-blue-200"></i></button>
        </div>
        <nav class="flex-1 px-6 py-8 space-y-3">
            <a href="/admin/dashboard" class="flex items-center p-4 bg-blue-600/20 text-blue-400 border border-blue-500/20 rounded-2xl font-bold text-sm">
                <i data-lucide="layout-grid" class="mr-3 w-5 h-5"></i> Dashboard Overview
            </a>
            <a href="#" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white">
                <i data-lucide="message-circle" class="mr-3 w-5 h-5"></i> Daftar Aduan
            </a>
        </nav>
        <div class="p-8 border-t border-white/5">
            <a href="/" class="flex items-center p-4 hover:bg-red-500/10 rounded-2xl transition text-red-400 font-bold text-sm"><i data-lucide="power" class="mr-3 w-5 h-5"></i> Logout</a>
        </div>
    </div>

    <div class="min-h-screen flex flex-col">
        <header class="h-24 bg-white border-b px-10 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <button @click="open = true" class="w-12 h-12 flex flex-col items-center justify-center gap-1.5 bg-white hover:bg-blue-50 rounded-2xl transition border border-slate-200">
                <div class="w-6 h-0.5 bg-blue-900 rounded-full"></div>
                <div class="w-6 h-0.5 bg-blue-600 rounded-full"></div>
                <div class="w-4 h-0.5 bg-blue-900 rounded-full"></div>
            </button>
            <div class="flex items-center gap-6">
                <div class="text-right leading-none hidden sm:block">
                    <p class="text-sm font-bold text-slate-900">Admin </p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Administrator Utama</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-tr from-blue-700 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold shadow-lg">FM</div>
            </div>
        </header>

        <main class="p-8 md:p-12 space-y-12 max-w-7xl mx-auto w-full">
            <div class="bg-gradient-to-br from-[#0F172A] via-[#1E40AF] to-blue-600 rounded-[3rem] p-12 text-white shadow-2xl relative overflow-hidden">
                <h2 class="text-5xl font-sora font-extrabold tracking-tighter italic">SITAMPAN <span class="text-blue-300 font-light not-italic">Admin</span></h2>
                <p class="text-blue-100/80 max-w-lg text-lg font-light mt-4 leading-relaxed">Kelola pengaduan dan pantau sentimen mahasiswa Universitas Tadulako hari ini.</p>
                <img src="{{ asset('img/Logo Untad Baru-jukebox-bg-removed.jpg') }}" class="absolute right-12 bottom-[-15%] w-80 opacity-10 grayscale invert rotate-12 pointer-events-none">
            </div>

            <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                    <h3 class="font-sora font-bold text-xl text-slate-900">Aduan Mahasiswa Terkini</h3>
                    <span class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black rounded-xl uppercase tracking-widest">Semua Data</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] text-slate-400 uppercase tracking-[0.3em] border-b border-slate-50">
                                <th class="px-10 py-6 font-bold">Identitas Pelapor</th>
                                <th class="px-10 py-6 font-bold">Kategori</th>
                                <th class="px-10 py-6 font-bold">Subjek</th>
                                <th class="px-10 py-6 font-bold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($laporans as $laporan)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center font-bold text-blue-600">
                                            <i data-lucide="user" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-slate-900">{{ $laporan->user->name ?? 'Mahasiswa' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-xs font-bold text-slate-500 uppercase italic">{{ $laporan->kategori }}</td>
                                <td class="px-10 py-8 text-xs font-bold text-slate-700">{{ $laporan->subjek }}</td>
                                <td class="px-10 py-8 text-center flex justify-center items-center gap-2">
                                    <span class="px-4 py-1.5 bg-slate-100 text-slate-700 rounded-xl text-[9px] font-black uppercase ring-1 ring-slate-200">{{ $laporan->status }}</span>
                                    
                                    <form action="{{ route('laporan.updateStatus', $laporan->id) }}" method="POST" class="flex gap-2 items-center ml-2 border-l border-slate-200 pl-4">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="bg-white border border-slate-200 text-xs rounded-lg px-2 py-1 outline-none">
                                            <option value="baru" {{ $laporan->status == 'baru' ? 'selected' : '' }}>Baru</option>
                                            <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-1 rounded-lg transition" title="Update Status">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus laporan ini?')" class="bg-slate-100 hover:bg-red-100 text-slate-400 hover:text-red-500 p-1.5 rounded-lg transition border border-transparent hover:border-red-200" title="Hapus Laporan">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-10 py-8 text-center text-slate-500 font-medium">Belum ada laporan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>