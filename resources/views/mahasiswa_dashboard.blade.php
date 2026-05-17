<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fe; }
        .font-sora { font-family: 'Sora', sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        [x-cloak] { display: none !important; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }
    </style>
</head>
<body class="text-slate-800 min-h-screen" x-data="{ open: false }">

    <div x-show="open" @click="open = false" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60]"></div>
    <div x-show="open" x-cloak class="fixed inset-y-0 left-0 w-72 bg-[#0f172a] text-white z-[70] shadow-2xl flex flex-col border-r border-white/5 transition-all">
        <div class="p-8 flex items-center gap-4 border-b border-white/10">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/40"><i data-lucide="shield-check" class="w-6 h-6 text-white"></i></div>
            <span class="font-sora font-extrabold text-xl tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">SITAMPAN</span>
        </div>
        <nav class="flex-1 px-4 py-8 space-y-2">
            <a href="/mahasiswa/dashboard" class="flex items-center px-5 py-4 bg-blue-600/15 text-blue-400 rounded-2xl font-bold text-sm border border-blue-500/20">
                <i data-lucide="layout-grid" class="mr-3 w-5 h-5"></i> Beranda
            </a>
            <a href="/mahasiswa/buat-aduan" class="flex items-center px-5 py-4 hover:bg-white/5 rounded-2xl transition-all text-slate-400 hover:text-white group">
                <i data-lucide="plus-circle" class="mr-3 w-5 h-5 group-hover:text-blue-400 transition-colors"></i> Buat Aduan Baru
            </a>
        </nav>
        <div class="p-6 border-t border-white/10">
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="flex items-center justify-center p-4 w-full bg-red-500/10 hover:bg-red-500/20 rounded-2xl transition-all text-red-400 font-bold text-sm border border-red-500/10 hover:border-red-500/30"><i data-lucide="power" class="mr-2 w-4 h-4"></i> Keluar</button>
            </form>
        </div>
    </div>

    <div class="flex flex-col min-h-screen">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 px-6 lg:px-12 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button @click="open = true" class="p-2.5 bg-slate-100/80 rounded-xl hover:bg-slate-200 transition-colors text-slate-600"><i data-lucide="menu" class="w-5 h-5"></i></button>
                <h1 class="font-sora font-bold text-xl text-slate-800 hidden sm:block">SITAMPAN <span class="text-blue-600 font-normal">Student</span></h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-900 leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-blue-600 font-black tracking-widest uppercase mt-0.5">Mahasiswa</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md shadow-blue-500/30 ring-2 ring-white/50">{{ substr(auth()->user()->name, 0, 2) }}</div>
            </div>
        </header>

        <main class="p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-8">
            <div class="bg-[#0f172a] rounded-[2rem] p-10 lg:p-14 text-white shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between border border-slate-800">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-purple-600/20 pointer-events-none"></div>
                <div class="relative z-10 max-w-xl text-center md:text-left">
                    <span class="px-3 py-1 bg-blue-500/20 text-blue-300 text-[10px] font-black uppercase tracking-widest rounded-full border border-blue-400/30 mb-4 inline-block">Layanan Pengaduan 24/7</span>
                    <h2 class="text-4xl lg:text-5xl font-sora font-extrabold tracking-tight mt-2 mb-4">Halo, {{ explode(' ', auth()->user()->name)[0] }} 👋</h2>
                    <p class="text-slate-300 text-sm lg:text-base leading-relaxed mb-8">Punya kendala akademik atau fasilitas kampus? Sampaikan laporanmu di sini. Suaramu sangat berarti untuk perubahan.</p>
                    <a href="/mahasiswa/buat-aduan" class="px-8 py-3.5 bg-white text-slate-900 rounded-xl font-bold text-sm shadow-xl shadow-white/10 hover:shadow-white/20 hover:-translate-y-1 transition-all inline-flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i> Buat Aduan Baru
                    </a>
                </div>
                <div class="hidden md:block relative z-10 animate-float">
                    <div class="w-40 h-40 bg-gradient-to-tr from-blue-500 to-indigo-500 rounded-full blur-2xl absolute opacity-40"></div>
                    <img src="{{ asset('img/Logo Untad Baru.png') }}" class="w-56 relative drop-shadow-2xl brightness-110">
                </div>
            </div>

            @php
                $listLaporan = $laporans ?? collect([]);
                $totalCount = $listLaporan->count();
                $prosesCount = $listLaporan->where('status', 'diproses')->count();
                $selesaiCount = $listLaporan->where('status', 'selesai')->count();
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="glass-card p-6 rounded-[1.5rem] shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow border border-slate-200/60">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 border border-blue-100"><i data-lucide="file-text" class="w-6 h-6"></i></div>
                    <div><p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Aduan</p><h3 class="text-2xl font-sora font-bold text-slate-800">{{ sprintf('%02d', $totalCount) }}</h3></div>
                </div>
                <div class="glass-card p-6 rounded-[1.5rem] shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow border border-slate-200/60">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 border border-amber-100"><i data-lucide="loader" class="w-6 h-6 animate-spin-slow"></i></div>
                    <div><p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Diproses</p><h3 class="text-2xl font-sora font-bold text-slate-800">{{ sprintf('%02d', $prosesCount) }}</h3></div>
                </div>
                <div class="glass-card p-6 rounded-[1.5rem] shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow border border-slate-200/60">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 border border-emerald-100"><i data-lucide="check-circle-2" class="w-6 h-6"></i></div>
                    <div><p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Selesai</p><h3 class="text-2xl font-sora font-bold text-slate-800">{{ sprintf('%02d', $selesaiCount) }}</h3></div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-8 h-8 bg-blue-600/10 rounded-lg flex items-center justify-center"><i data-lucide="message-square" class="w-4 h-4 text-blue-600"></i></div>
                    <h3 class="text-lg font-sora font-bold text-slate-800">Riwayat Laporan Anda</h3>
                </div>
                
                <div class="grid grid-cols-1 gap-5">
                    @forelse($listLaporan as $laporan)
                    <div class="bg-white rounded-[1.5rem] shadow-sm border border-slate-200 overflow-hidden hover:border-blue-300 transition-colors" x-data="{ showChat: false }">
                        <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-5 bg-slate-50/30">
                            <div class="flex items-start md:items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-blue-600 font-black text-lg">{{ substr($laporan->kategori, 0, 1) }}</div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded">{{ $laporan->kategori }}</p>
                                        <span class="text-[10px] text-slate-400">• {{ $laporan->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="text-base font-bold text-slate-900 leading-snug">{{ $laporan->subjek }}</h4>
                                    <p class="text-[11px] text-slate-500 mt-1.5 font-medium">Tiket: <span class="text-slate-700">#TP-{{ $laporan->id }}</span></p>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto mt-2 md:mt-0 pt-4 md:pt-0 border-t md:border-0 border-slate-100">
                                <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border
                                    {{ $laporan->status == 'baru' ? 'bg-blue-50 text-blue-600 border-blue-100' : ($laporan->status == 'diproses' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100') }}">
                                    {{ $laporan->status }}
                                </span>
                                
                                <a href="{{ route('laporan.cetak', $laporan->id) }}" target="_blank" class="p-2 bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors border border-transparent hover:border-red-100 group" title="Cetak PDF">
                                    <i data-lucide="printer" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                                </a>

                                <button @click="showChat = !showChat" class="px-5 py-2 bg-slate-900 text-white rounded-lg text-[11px] font-bold hover:bg-blue-600 transition-colors flex items-center gap-2 flex-1 md:flex-none justify-center">
                                    <span x-text="showChat ? 'Tutup' : 'Lihat Chat'"></span>
                                </button>
                            </div>
                        </div>

                        <div x-show="showChat" x-cloak x-transition class="border-t border-slate-100 bg-white">
                            <div class="p-6 md:p-8 space-y-6">
                                <div class="bg-slate-50 rounded-[1.5rem] p-5 max-h-[350px] overflow-y-auto space-y-4 border border-slate-100 inset-shadow-sm">
                                    @foreach($laporan->messages as $msg)
                                    <div class="flex {{ $msg->sender == 'mahasiswa' ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[85%] {{ $msg->sender == 'mahasiswa' ? 'bg-blue-600 text-white rounded-tl-xl rounded-tr-xl rounded-bl-xl' : 'bg-white border border-slate-200 text-slate-700 rounded-tr-xl rounded-br-xl rounded-bl-xl shadow-sm' }} px-5 py-3 text-[13px] font-medium leading-relaxed">
                                            @if($msg->sender == 'admin')
                                                <div class="flex items-center gap-1.5 mb-1.5 opacity-80">
                                                    <i data-lucide="{{ $msg->source == 'ai' ? 'bot' : 'shield-check' }}" class="w-3.5 h-3.5 {{ $msg->source == 'ai' ? 'text-indigo-500' : 'text-slate-500' }}"></i>
                                                    <span class="text-[9px] font-black uppercase tracking-widest {{ $msg->source == 'ai' ? 'text-indigo-500' : 'text-slate-500' }}">
                                                        {{ $msg->source == 'ai' ? 'AI Assistant' : 'Admin' }}
                                                    </span>
                                                </div>
                                            @endif
                                            {!! nl2br(e($msg->message)) !!}
                                            <span class="text-[9px] opacity-50 mt-2 block text-right">{{ $msg->created_at->format('H:i') }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                @if($laporan->status !== 'selesai')
                                <form action="{{ route('mahasiswa.send_message', $laporan->id) }}" method="POST" class="relative">
                                    @csrf
                                    <input type="text" name="message" placeholder="Tulis balasan Anda di sini..." class="w-full pl-5 pr-24 py-3.5 bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 rounded-xl transition-all outline-none text-sm font-medium" required>
                                    <button type="submit" class="absolute right-2 top-2 bottom-2 px-5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-xs uppercase tracking-widest transition-colors flex items-center gap-1.5 shadow-md shadow-blue-500/20">Kirim</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white p-16 rounded-[2rem] border border-dashed border-slate-300 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4"><i data-lucide="inbox" class="w-8 h-8 text-slate-300"></i></div>
                        <h4 class="text-slate-800 font-bold mb-1">Belum Ada Laporan</h4>
                        <p class="text-sm text-slate-500">Anda belum membuat aduan apapun ke sistem.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>