<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
        .bg-app {
            background-color: #F8FAFC;
            background-image: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.04) 0px, transparent 50%), 
                              radial-gradient(at 100% 100%, rgba(30, 58, 138, 0.04) 0px, transparent 50%);
        }
        [x-cloak] { display: none !important; }
        .animate-spin-slow { animation: spin 8s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-app text-slate-800 min-h-screen" x-data="{ open: false }">

    <div x-show="open" @click="open = false" x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[60]"></div>

    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 w-72 bg-slate-900 text-white z-[70] shadow-2xl flex flex-col border-r border-white/5">
        
        <div class="p-8 flex justify-between items-center border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                </div>
                <span class="font-sora font-extrabold text-xl tracking-tighter text-blue-400 italic uppercase">SITAMPAN</span>
            </div>
            <button @click="open = false" class="p-2 hover:bg-white/10 rounded-full transition"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <nav class="flex-1 px-6 py-8 space-y-3">
            <a href="/mahasiswa/dashboard" class="flex items-center p-4 bg-blue-600/20 text-blue-400 border border-blue-500/20 rounded-2xl font-bold text-sm">
                <i data-lucide="layout-grid" class="mr-3 w-5 h-5"></i> Beranda
            </a>
            <a href="/mahasiswa/buat-aduan" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group">
                <i data-lucide="plus-circle" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Buat Aduan Baru
            </a>
            <a href="/mahasiswa/riwayat" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group">
                <i data-lucide="history" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Riwayat Aduan
            </a>
            <a href="/profile" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group">
                <i data-lucide="user" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Profil Saya
            </a>
        </nav>

        <div class="p-8 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center p-4 w-full hover:bg-red-500/10 rounded-2xl transition text-red-400 font-bold text-sm group text-left">
                    <i data-lucide="power" class="mr-3 w-5 h-5 group-hover:scale-110 transition-transform"></i> Keluar Aplikasi
                </button>
            </form>
        </div>
    </div>

    <div class="flex flex-col min-h-screen">
        <header class="h-20 bg-white/80 backdrop-blur-lg border-b border-slate-100 px-6 md:px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-5">
                <button @click="open = true" class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 hover:bg-slate-100 transition text-slate-600">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="hidden sm:block">
                    <h1 class="font-sora font-black text-xl italic text-slate-900 tracking-tighter leading-none uppercase">
                        SITAMPAN <span class="text-blue-600 font-light not-italic text-lg">Student</span>
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right leading-none hidden md:block uppercase">
                    <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-[10px] text-blue-600 font-bold tracking-widest mt-1">{{ auth()->user()->role ?? 'Student' }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg ring-2 ring-white uppercase">
                    {{ substr(auth()->user()->name ?? 'MH', 0, 2) }}
                </div>
            </div>
        </header>

        <main class="p-6 md:p-10 max-w-6xl mx-auto w-full space-y-10">
            
            <div class="bg-gradient-to-br from-[#0F172A] via-[#1E40AF] to-blue-600 rounded-[2.5rem] p-10 md:p-14 text-white shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between border border-slate-800">
                <div class="relative z-10 max-w-xl text-center md:text-left">
                    <h2 class="text-4xl md:text-5xl font-sora font-extrabold tracking-tighter italic uppercase">Halo, {{ explode(' ', auth()->user()->name ?? 'User')[0] }}! 👋</h2>
                    <p class="text-blue-100/80 text-lg font-light mt-4 leading-relaxed">Selamat datang di sistem layanan pengaduan terpadu. Kami siap mendengar dan membantu menyelesaikan kendalamu.</p>
                    
                    <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-4">
                        <a href="/mahasiswa/buat-aduan" class="px-8 py-4 bg-white text-blue-600 rounded-2xl font-sora font-black text-xs uppercase tracking-widest shadow-xl hover:scale-105 transition-all flex items-center gap-2">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i> Buat Aduan Baru
                        </a>
                        <a href="/mahasiswa/riwayat" class="px-8 py-4 bg-blue-500/20 backdrop-blur-md border border-white/20 text-white rounded-2xl font-sora font-black text-xs uppercase tracking-widest hover:bg-white/10 transition-all inline-flex items-center justify-center cursor-pointer">
                            Lihat Riwayat
                        </a>
                    </div>
                </div>
                <img src="{{ asset('img/Logo Untad Baru.png') }}" class="absolute right-[-2%] bottom-[-15%] w-80 opacity-20 pointer-events-none drop-shadow-2xl transition-transform hover:scale-105 duration-700">
            </div>

            @php
                $totalAduan = count($laporans ?? []);
                $totalSelesai = collect($laporans ?? [])->where('status', 'selesai')->count();
                $totalProses = collect($laporans ?? [])->where('status', 'diproses')->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform shadow-inner"><i data-lucide="send" class="w-8 h-8"></i></div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Aduan</p>
                        <h3 class="text-3xl font-sora font-bold text-slate-800">{{ sprintf('%02d', $totalAduan) }}</h3>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform shadow-inner"><i data-lucide="clock" class="w-8 h-8 animate-spin-slow"></i></div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sedang Proses</p>
                        <h3 class="text-3xl font-sora font-bold text-amber-500">{{ sprintf('%02d', $totalProses) }}</h3>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform shadow-inner"><i data-lucide="check-circle" class="w-8 h-8"></i></div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Aduan Selesai</p>
                        <h3 class="text-3xl font-sora font-bold text-emerald-500">{{ sprintf('%02d', $totalSelesai) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-blue-600 rounded-[2.5rem] p-8 md:p-12 text-white flex flex-col md:flex-row items-center gap-8 shadow-2xl shadow-blue-200 border border-blue-400 relative overflow-hidden">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-xl rounded-3xl flex items-center justify-center shrink-0 shadow-lg relative z-10">
                    <i data-lucide="help-circle" class="w-10 h-10"></i>
                </div>
                <div class="text-center md:text-left relative z-10 uppercase">
                    <h4 class="text-xl font-sora font-bold tracking-tight">Butuh Bantuan Mendesak?</h4>
                    <p class="text-blue-100/80 mt-2 font-medium normal-case">Jika kendalamu belum mendapatkan tanggapan lebih dari 2x24 jam, silakan hubungi pusat bantuan admin melalui WhatsApp.</p>
                </div>
                <a href="https://wa.me/6281234567890" target="_blank" 
                   class="px-8 py-5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shrink-0 hover:bg-slate-800 transition-all hover:scale-105 shadow-xl relative z-10 flex items-center gap-3">
                    <i data-lucide="message-circle" class="w-4 h-4"></i> Hubungi Kami
                </a>
            </div>

        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>