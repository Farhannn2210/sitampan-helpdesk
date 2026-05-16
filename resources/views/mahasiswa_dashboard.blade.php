<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Mahasiswa | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800" x-data="{ open: false }">

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 w-72 bg-slate-900 text-white z-50 shadow-2xl flex flex-col">
        
        <div class="p-8 border-b border-white/5 flex justify-between items-center">
            <span class="font-sora font-extrabold text-xl italic text-blue-400">SITAMPAN</span>
            <button @click="open = false" class="text-white/50 hover:text-white"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <nav class="flex-1 px-6 py-8 space-y-2">
            <a href="/mahasiswa/dashboard" class="flex items-center p-4 bg-blue-600 rounded-2xl font-bold text-sm shadow-lg shadow-blue-900/20 text-white">
                <i data-lucide="home" class="mr-3 w-5 h-5"></i> Beranda
            </a>
            <a href="/mahasiswa/buat-aduan" class="flex items-center p-4 hover:bg-white/5 rounded-2xl text-slate-400 transition group">
                <i data-lucide="plus-circle" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Buat Aduan Baru
            </a>
            <a href="#" class="flex items-center p-4 hover:bg-white/5 rounded-2xl text-slate-400 transition group">
                <i data-lucide="history" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Riwayat Aduan
            </a>
        </nav>

        <div class="p-8 border-t border-white/5">
            <a href="/" class="text-red-400 font-bold flex items-center hover:text-red-300 transition">
                <i data-lucide="log-out" class="mr-2 w-5 h-5"></i> Keluar
            </a>
        </div>
    </div>

    <div x-show="open" @click="open = false" class="fixed inset-0 bg-black/50 z-40 backdrop-blur-sm"></div>

    <div class="min-h-screen flex flex-col">
        <header class="h-20 bg-white border-b px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <button @click="open = true" class="p-2 bg-slate-50 rounded-xl border border-slate-200 hover:bg-slate-100 transition">
                <i data-lucide="menu" class="w-6 h-6 text-slate-600"></i>
            </button>
            <div class="flex items-center gap-4">
                <div class="text-right leading-none">
                    <p class="text-sm font-bold">Muh. Farhan Dg. Masese</p>
                    <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">Mahasiswa</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200">
                    FM
                </div>
            </div>
        </header>

        <main class="p-8 max-w-5xl mx-auto w-full space-y-8">
            <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 rounded-[2.5rem] p-10 md:p-14 text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <h2 class="text-4xl font-sora font-extrabold leading-tight tracking-tighter">Halo, Farhan! 👋</h2>
                    <p class="mt-3 text-blue-100 opacity-90 max-w-md font-light">Ada kendala akademik atau fasilitas kampus hari ini? Tim SITAMPAN siap memproses laporanmu.</p>
                    <a href="/mahasiswa/buat-aduan" class="mt-8 inline-flex items-center px-8 py-4 bg-white text-blue-700 rounded-2xl font-bold text-sm shadow-xl hover:scale-105 transition-all duration-300">
                        <i data-lucide="plus" class="mr-2 w-4 h-4"></i> Buat Laporan Sekarang
                    </a>
                </div>
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition duration-1000"></div>
            </div>

            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Aduan Saya Terbaru</h3>
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Update 2026</span>
                </div>
                <div class="p-8 space-y-4">
                    @forelse ($laporans as $laporan)
                    <div class="p-6 bg-white border-2 border-slate-50 rounded-[2rem] hover:border-blue-100 transition shadow-sm" x-data="{ openChat:false }">
                        <div class="flex items-center justify-between gap-6">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 font-bold">
                                    <i data-lucide="clock" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 italic text-sm">"{{ $laporan->subjek }}"</p>
                                    <p class="text-[10px] text-slate-400 font-medium mt-1">
                                        <span class="uppercase">{{ $laporan->kategori }}</span> • {{ $laporan->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="px-4 py-1.5 
                                    @if($laporan->status == 'baru') bg-blue-50 text-blue-700 ring-blue-200
                                    @elseif($laporan->status == 'diproses') bg-amber-50 text-amber-700 ring-amber-200
                                    @elseif($laporan->status == 'selesai') bg-green-50 text-green-700 ring-green-200
                                    @else bg-red-50 text-red-700 ring-red-200 @endif
                                    rounded-xl text-[10px] font-black uppercase tracking-tighter ring-1">
                                    {{ $laporan->status }}
                                </span>

                                <button type="button" @click="openChat = !openChat" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-[10px] font-black rounded-xl uppercase tracking-widest flex items-center gap-2">
                                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                                    <span x-text="openChat ? 'Tutup Chat' : 'Lihat Chat'"></span>
                                </button>
                            </div>
                        </div>

                        <div x-cloak x-show="openChat" class="mt-6 space-y-4">
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                                <div class="max-h-64 overflow-y-auto space-y-3">
                                    @forelse ($laporan->messages as $msg)
                                        @if ($msg->sender === 'admin')
                                            <div class="flex justify-end">
                                                <div class="max-w-[85%] bg-slate-900 text-white rounded-2xl px-4 py-3">
                                                    <div class="flex items-center justify-between gap-3 mb-1">
                                                        <p class="text-[10px] font-black uppercase tracking-widest text-white/70">Admin</p>
                                                        <span class="text-[10px] font-bold text-white/60">{{ $msg->created_at->format('d M Y H:i') }}</span>
                                                    </div>
                                                    <p class="text-xs font-semibold leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex justify-start">
                                                <div class="max-w-[85%] bg-white border border-slate-200 rounded-2xl px-4 py-3">
                                                    <div class="flex items-center justify-between gap-3 mb-1">
                                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Saya</p>
                                                        <span class="text-[10px] font-bold text-slate-400">{{ $msg->created_at->format('d M Y H:i') }}</span>
                                                    </div>
                                                    <p class="text-xs font-semibold leading-relaxed whitespace-pre-line text-slate-700">{{ $msg->message }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <p class="text-xs text-slate-500 font-semibold">Belum ada percakapan.</p>
                                    @endforelse
                                </div>
                            </div>

                            <form action="{{ route('laporan.mahasiswaSendMessage', $laporan->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <textarea name="message" rows="3" required class="w-full px-5 py-4 bg-white border-2 border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 outline-none resize-none shadow-sm" placeholder="Tulis pesan lanjutan untuk admin..."></textarea>
                                <div class="flex items-center justify-end">
                                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-black text-xs rounded-2xl uppercase tracking-widest">Kirim Pesan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <p class="text-slate-500 font-medium">Belum ada aduan yang kamu buat.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>