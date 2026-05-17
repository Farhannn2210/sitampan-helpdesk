<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fe; }
        .font-sora { font-family: 'Sora', sans-serif; }
        [x-cloak] { display: none !important; }
        .swal2-popup { border-radius: 1.5rem !important; font-family: 'Inter', sans-serif !important; }
        .animate-spin-slow { animation: spin 3s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body class="text-slate-800 min-h-screen relative" x-data="{ open: false }">

    <div x-show="open" @click="open = false" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[90]"></div>
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 w-72 bg-[#0f172a] text-white z-[100] shadow-2xl flex flex-col border-r border-white/5">
        <div class="p-8 flex justify-between items-center border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg"><i data-lucide="shield-check" class="w-6 h-6 text-white"></i></div>
                <div><span class="font-sora font-extrabold text-xl tracking-tighter block leading-none uppercase italic text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">SITAMPAN</span><span class="text-[9px] text-blue-400 font-bold uppercase tracking-[0.2em]">Helpdesk Panel</span></div>
            </div>
            <button @click="open = false" class="p-2 hover:bg-white/10 rounded-full text-blue-200 transition"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <nav class="flex-1 px-4 py-8 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-5 py-4 bg-blue-600/15 text-blue-400 border border-blue-500/20 rounded-2xl font-bold text-sm shadow-lg shadow-blue-900/20">
                <i data-lucide="layout-grid" class="mr-3 w-5 h-5"></i> Dashboard Overview
            </a>
            <a href="{{ route('profile') }}" class="flex items-center px-5 py-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group">
                <i data-lucide="user-cog" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Profil Admin
            </a>
        </nav>
        <div class="p-6 border-t border-white/10">
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="flex items-center justify-center p-4 w-full bg-red-500/10 hover:bg-red-500/20 rounded-2xl transition-all text-red-400 font-bold text-sm border border-red-500/10"><i data-lucide="power" class="mr-2 w-4 h-4"></i> Logout Sistem</button>
            </form>
        </div>
    </div>

    <div class="flex flex-col min-h-screen">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 px-6 md:px-10 flex items-center justify-between sticky top-0 z-40 shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="open = true" class="p-2.5 bg-slate-100/80 rounded-xl hover:bg-slate-200 transition-colors text-slate-600 relative z-50">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <h1 class="font-sora font-bold text-xl italic text-slate-900 uppercase hidden sm:block">SITAMPAN <span class="text-blue-600 font-normal not-italic">Admin</span></h1>
            </div>
            <div class="flex items-center gap-4 uppercase">
                <div class="text-right leading-none hidden md:block">
                    <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-black text-blue-600 tracking-widest mt-1">Administrator</p>
                </div>
                <a href="{{ route('profile') }}" class="w-10 h-10 bg-gradient-to-tr from-blue-700 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md shadow-blue-500/30 hover:scale-105 transition-transform">{{ substr(auth()->user()->name, 0, 2) }}</a>
            </div>
        </header>

        <main class="p-6 md:p-10 max-w-7xl mx-auto w-full space-y-8">
            <div class="bg-[#0f172a] rounded-[2rem] p-10 md:p-14 text-white shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between border border-slate-800">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-indigo-600/20 pointer-events-none"></div>
                <div class="relative z-10 max-w-xl text-center md:text-left">
                    <span class="px-3 py-1 bg-blue-500/20 text-blue-300 text-[10px] font-black uppercase tracking-widest rounded-full border border-blue-400/30 mb-4 inline-block">Control Center</span>
                    <h2 class="text-4xl font-sora font-extrabold italic uppercase leading-tight mt-2">Halo, {{ auth()->user()->name }}!</h2>
                    <p class="text-slate-300 text-sm mt-3 leading-relaxed">Kelola pengaduan, ubah status tiket, pantau lampiran, dan balas pesan secara real-time di sini.</p>
                </div>
                <img src="{{ asset('img/Logo Untad Baru.png') }}" class="absolute right-[-2%] bottom-[-10%] w-72 opacity-20 pointer-events-none hidden md:block">
            </div>

            <div id="area-aduan" class="bg-white rounded-[2rem] shadow-sm border border-slate-200 p-2">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 rounded-t-[1.8rem] flex justify-between items-center">
                    <h3 class="font-sora font-bold text-lg text-slate-900">Antrean Aduan Mahasiswa</h3>
                </div>

                <div class="p-6 space-y-5">
                    @forelse ($laporans ?? [] as $laporan)
                    <div class="bg-white p-6 border-2 border-slate-100 hover:border-blue-200 rounded-[1.5rem] shadow-sm transition-all duration-300" x-data="{ openChat: false }">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center font-black text-blue-600 border border-slate-200 uppercase text-xl shadow-inner">
                                    {{ substr($laporan->user->name ?? 'Mh', 0, 2) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg leading-tight">"{{ $laporan->subjek }}"</h4>
                                    <p class="text-xs text-slate-500 font-medium mt-1">
                                        <span class="font-bold text-slate-700 uppercase">{{ $laporan->user->name }}</span> • <span class="text-blue-600 uppercase">{{ $laporan->kategori }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                                <a href="{{ route('laporan.cetak', $laporan->id) }}" target="_blank" class="p-2.5 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-xl transition-all shadow-sm flex items-center gap-2 group border border-red-100">
                                    <i data-lucide="printer" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                                </a>

                                <form action="{{ route('admin.laporan.updateStatus', $laporan->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-700 shadow-sm outline-none cursor-pointer hover:border-blue-400 transition-all">
                                        <option value="baru" {{ $laporan->status == 'baru' ? 'selected' : '' }}>🌟 Baru</option>
                                        <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>⏳ Diproses</option>
                                        <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                    </select>
                                </form>

                                <button type="button" @click="openChat = !openChat" class="px-5 py-2.5 bg-slate-900 hover:bg-blue-600 text-white text-[11px] font-bold rounded-xl flex items-center gap-2 shadow-md transition-colors flex-1 md:flex-none justify-center">
                                    <span x-text="openChat ? 'Tutup' : 'Lihat Detail'"></span>
                                </button>
                            </div>
                        </div>

                        <div x-cloak x-show="openChat" x-transition class="mt-6 pt-6 border-t border-slate-100 space-y-4">
                            
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1 bg-slate-50 border border-slate-200 rounded-2xl p-5">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Deskripsi Awal Laporan:</p>
                                    <p class="text-sm font-medium text-slate-700 leading-relaxed">{{ $laporan->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                </div>

                                <div class="md:w-1/3 bg-blue-50/50 border border-blue-100 rounded-2xl p-5 flex flex-col justify-center items-center text-center">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-blue-500 mb-3">Lampiran Mahasiswa:</p>
                                    @if($laporan->lampiran)
                                        <a href="{{ asset('storage/' . $laporan->lampiran) }}" target="_blank" class="flex flex-col items-center group">
                                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform border border-blue-200">
                                                <i data-lucide="image" class="w-6 h-6"></i>
                                            </div>
                                            <span class="text-[10px] font-bold text-blue-600 mt-2 bg-blue-100 px-2 py-1 rounded-md group-hover:bg-blue-600 group-hover:text-white transition-colors">Lihat Bukti Foto</span>
                                        </a>
                                    @else
                                        <i data-lucide="image-off" class="w-8 h-8 text-slate-300"></i>
                                        <span class="text-[10px] font-bold text-slate-400 mt-2 italic bg-white px-2 py-1 rounded-md border border-slate-200">Tanpa Lampiran</span>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 max-h-72 overflow-y-auto space-y-4 shadow-inner">
                                @forelse ($laporan->messages ?? [] as $msg)
                                    <div class="flex {{ $msg->sender === 'mahasiswa' ? 'justify-start' : 'justify-end' }}">
                                        <div class="max-w-[85%] {{ $msg->sender === 'mahasiswa' ? 'bg-white text-slate-700 border border-slate-200 rounded-tl-xl rounded-tr-xl rounded-br-xl' : 'bg-blue-600 text-white rounded-tl-xl rounded-tr-xl rounded-bl-xl' }} px-5 py-3 shadow-sm text-[13px] font-medium leading-relaxed">
                                            @if($msg->sender !== 'mahasiswa')
                                                <div class="flex items-center gap-1.5 mb-1.5 opacity-80">
                                                    <i data-lucide="{{ $msg->source == 'ai' ? 'bot' : 'shield-check' }}" class="w-3.5 h-3.5 {{ $msg->source == 'ai' ? 'text-indigo-300' : 'text-blue-200' }}"></i>
                                                    <span class="text-[9px] font-black uppercase tracking-widest {{ $msg->source == 'ai' ? 'text-indigo-300' : 'text-blue-200' }}">
                                                        {{ $msg->source == 'ai' ? 'AI Assistant' : 'Admin Utama' }}
                                                    </span>
                                                </div>
                                            @endif
                                            {!! nl2br(e($msg->message)) !!}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4"><p class="text-xs italic text-slate-400 font-medium">Belum ada percakapan.</p></div>
                                @endforelse
                            </div>

                            @if($laporan->status !== 'selesai')
                            <div class="flex flex-col sm:flex-row gap-3">
                                <form action="{{ route('admin.laporan.sendMessage', $laporan->id) }}" method="POST" class="relative flex-1">
                                    @csrf
                                    <textarea name="message" rows="2" required class="w-full pl-5 pr-28 py-3.5 bg-white border border-slate-300 rounded-xl text-sm font-medium outline-none focus:border-blue-500 transition-all resize-none shadow-sm" placeholder="Ketik balasan manual..."></textarea>
                                    <button type="submit" class="absolute right-2 top-2 bottom-2 px-5 bg-slate-900 hover:bg-blue-600 text-white font-bold text-[11px] rounded-lg uppercase tracking-widest transition-colors shadow-md">Kirim</button>
                                </form>

                                <form action="{{ route('laporan.generateResponAi', $laporan->id) }}" method="POST" class="shrink-0 h-[70px] sm:h-auto">
                                    @csrf
                                    <button type="submit" onclick="this.innerHTML='<i class=\'animate-spin\'>🌀</i> Mikir...'; this.classList.add('opacity-50');" class="h-full w-full sm:w-auto px-6 bg-gradient-to-tr from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black text-[11px] rounded-xl uppercase tracking-widest flex flex-col items-center justify-center gap-1 shadow-lg hover:scale-105 transition-all">
                                        <i data-lucide="sparkles" class="w-5 h-5 mb-0.5"></i> Balas AI
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20 border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50">
                        <i data-lucide="coffee" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                        <p class="uppercase text-slate-400 font-bold tracking-widest text-xs">Belum ada aduan masuk</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    @if(session('success') || session('error'))
    <script>
        const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, timerProgressBar: true });
        Toast.fire({ icon: "{{ session('success') ? 'success' : 'error' }}", title: "{!! session('success') ?? session('error') !!}" });
    </script>
    @endif
    <script>lucide.createIcons();</script>
</body>
</html>