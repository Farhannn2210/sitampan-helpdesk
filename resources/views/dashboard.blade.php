<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Sora:wght@400;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        .swal2-popup { border-radius: 1.5rem !important; font-family: 'Inter', sans-serif !important; }
        .animate-spin-slow { animation: spin 3s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-app text-slate-800 min-h-screen" x-data="{ open: false }">

    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 w-72 bg-slate-900 text-white z-50 shadow-2xl flex flex-col border-r border-white/5">
        
        <div class="p-8 flex justify-between items-center border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <span class="font-sora font-extrabold text-xl tracking-tighter block leading-none text-white uppercase italic">SITAMPAN</span>
                    <span class="text-[9px] text-blue-400 font-bold uppercase tracking-[0.2em]">Helpdesk Panel</span>
                </div>
            </div>
            <button @click="open = false" class="p-2 hover:bg-white/10 rounded-full transition text-blue-200"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <nav class="flex-1 px-6 py-8 space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-4 bg-blue-600/20 text-blue-400 border border-blue-500/20 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20">
                <i data-lucide="layout-grid" class="mr-3 w-5 h-5"></i> Dashboard Overview
            </a>
            <a href="#area-aduan" @click="open = false" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group">
                <i data-lucide="message-circle" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Manajemen Aduan
            </a>
            <a href="{{ route('profile') }}" @click="open = false" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group">
                <i data-lucide="user-cog" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Profil Admin
            </a>
        </nav>

        <div class="p-8 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center p-4 w-full hover:bg-red-500/10 rounded-2xl transition text-red-400 font-bold text-sm group text-left">
                    <i data-lucide="power" class="mr-3 w-5 h-5 group-hover:scale-110 transition-transform"></i> Logout Sistem
                </button>
            </form>
        </div>
    </div>

    <div x-show="open" @click="open = false" x-cloak x-transition.opacity class="fixed inset-0 bg-black/50 z-40 backdrop-blur-sm"></div>

    <div class="flex flex-col min-h-screen">
        <header class="h-20 bg-white/80 backdrop-blur-lg border-b border-slate-100 px-6 md:px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-5">
                <button @click="open = true" class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 hover:bg-slate-100 transition text-slate-600">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="hidden sm:block">
                    <h1 class="font-sora font-black text-xl italic text-slate-900 tracking-tighter leading-none">
                        SITAMPAN <span class="text-blue-600 font-light not-italic text-lg">Admin</span>
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right leading-none hidden md:block uppercase">
                    <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] font-bold text-slate-400 tracking-widest mt-0.5">Administrator Utama</p>
                </div>
                <a href="{{ route('profile') }}" class="w-10 h-10 bg-gradient-to-tr from-blue-700 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200 ring-2 ring-white uppercase transition-transform hover:scale-105">
                    {{ substr(auth()->user()->name ?? 'AD', 0, 2) }}
                </a>
            </div>
        </header>

        <main class="p-6 md:p-10 max-w-7xl mx-auto w-full space-y-8">
            <div class="bg-gradient-to-br from-[#0F172A] via-[#1E40AF] to-blue-600 rounded-[2.5rem] p-10 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between border border-slate-800">
                <div class="relative z-10 max-w-xl text-center md:text-left">
                    <h2 class="text-4xl font-sora font-extrabold tracking-tighter italic uppercase leading-tight">Halo, {{ auth()->user()->name ?? 'Admin' }}!</h2>
                    <p class="text-blue-100/80 text-sm mt-3 leading-relaxed">Kelola pengaduan, pantau sentimen mahasiswa, ubah status tiket, dan balas pesan secara real-time di sini.</p>
                </div>
                <img src="{{ asset('img/Logo Untad Baru.png') }}" class="absolute right-[-2%] bottom-[-10%] w-72 opacity-20 pointer-events-none drop-shadow-2xl transition-transform hover:scale-105 duration-700">
            </div>

            @php
                $totalAduan = collect($laporans ?? [])->count();
                $aduanBaru = collect($laporans ?? [])->where('status', 'baru')->count();
                $aduanDiproses = collect($laporans ?? [])->where('status', 'diproses')->count();
                $aduanSelesai = collect($laporans ?? [])->where('status', 'selesai')->count();
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex flex-col gap-3">
                    <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-600"><i data-lucide="inbox" class="w-5 h-5"></i></div>
                    <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Tiket</p><h3 class="text-3xl font-sora font-bold text-slate-800">{{ sprintf('%02d', $totalAduan) }}</h3></div>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex flex-col gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600"><i data-lucide="alert-circle" class="w-5 h-5"></i></div>
                    <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Tiket Baru</p><h3 class="text-3xl font-sora font-bold text-blue-600">{{ sprintf('%02d', $aduanBaru) }}</h3></div>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex flex-col gap-3">
                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500"><i data-lucide="loader-2" class="w-5 h-5 animate-spin-slow"></i></div>
                    <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Diproses</p><h3 class="text-3xl font-sora font-bold text-amber-500">{{ sprintf('%02d', $aduanDiproses) }}</h3></div>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex flex-col gap-3">
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500"><i data-lucide="check-circle-2" class="w-5 h-5"></i></div>
                    <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Selesai</p><h3 class="text-3xl font-sora font-bold text-emerald-500">{{ sprintf('%02d', $aduanSelesai) }}</h3></div>
                </div>
            </div>

            <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                <a href="{{ route('admin.dashboard', ['status' => 'semua']) }}" class="px-4 py-2 {{ request('status') == 'semua' || !request('status') ? 'bg-slate-900 text-white' : 'bg-white text-slate-500 border border-slate-200 shadow-sm' }} rounded-full text-[10px] font-black uppercase tracking-widest transition-all">Semua</a>
                <a href="{{ route('admin.dashboard', ['status' => 'baru']) }}" class="px-4 py-2 {{ request('status') == 'baru' ? 'bg-blue-600 text-white' : 'bg-white text-slate-500 border border-slate-200 shadow-sm' }} rounded-full text-[10px] font-black uppercase tracking-widest transition-all">🌟 Baru</a>
                <a href="{{ route('admin.dashboard', ['status' => 'diproses']) }}" class="px-4 py-2 {{ request('status') == 'diproses' ? 'bg-amber-500 text-white' : 'bg-white text-slate-500 border border-slate-200 shadow-sm' }} rounded-full text-[10px] font-black uppercase tracking-widest transition-all">⏳ Diproses</a>
                <a href="{{ route('admin.dashboard', ['status' => 'selesai']) }}" class="px-4 py-2 {{ request('status') == 'selesai' ? 'bg-emerald-500 text-white' : 'bg-white text-slate-500 border border-slate-200 shadow-sm' }} rounded-full text-[10px] font-black uppercase tracking-widest transition-all">✅ Selesai</a>
            </div>

            <div id="area-aduan" class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-2 scroll-mt-24">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50 rounded-t-[1.8rem]">
                    <h3 class="font-sora font-bold text-lg text-slate-900">Antrean Aduan Mahasiswa</h3>
                    <div class="px-3 py-1.5 bg-blue-50 text-blue-700 text-[9px] font-black rounded-lg uppercase tracking-widest flex items-center gap-2 border border-blue-100">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span> Live Sync
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    @forelse ($laporans ?? [] as $laporan)
                    <div class="bg-slate-50 hover:bg-white p-6 md:p-8 border-2 border-slate-100 hover:border-blue-200 rounded-[1.5rem] shadow-sm hover:shadow-xl transition-all duration-300" x-data="{ openChat: false }">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center font-black text-blue-600 border border-slate-200 shadow-sm flex-shrink-0 uppercase text-xl">
                                    {{ substr($laporan->user->name ?? 'Mh', 0, 2) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg">"{{ $laporan->subjek }}"</h4>
                                    <p class="text-xs text-slate-500 font-medium mt-1.5 uppercase">
                                        <span class="font-bold text-slate-700">{{ $laporan->user->name ?? 'Mahasiswa' }}</span> • <span class="text-blue-600">{{ $laporan->kategori }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 w-full md:w-auto">
                                <form action="{{ route('admin.laporan.updateStatus', $laporan->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-700 shadow-sm outline-none cursor-pointer hover:border-blue-400 transition-all">
                                        <option value="baru" {{ $laporan->status == 'baru' ? 'selected' : '' }}>🌟 Baru</option>
                                        <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>⏳ Diproses</option>
                                        <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                    </select>
                                </form>

                                <button type="button" @click="openChat = !openChat" class="px-5 py-2.5 bg-slate-900 hover:bg-blue-700 text-white text-[10px] font-black rounded-xl uppercase tracking-widest flex items-center gap-2 shadow-md transition-all">
                                    <i data-lucide="message-square" class="w-4 h-4"></i> <span x-text="openChat ? 'Tutup' : 'Tanggapi'"></span>
                                </button>

                                <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus laporan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white border border-red-100 rounded-xl transition-all shadow-sm">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div x-cloak x-show="openChat" x-transition class="mt-6 pt-6 border-t border-slate-200 space-y-4">
                            
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1 bg-red-50 border border-red-100 rounded-[1.2rem] p-5 shadow-inner">
                                    <p class="text-[10px] font-black uppercase text-red-500 mb-2 flex items-center gap-1 leading-none"><i data-lucide="alert-circle" class="w-3 h-3"></i> Deskripsi Awal:</p>
                                    <p class="text-sm font-medium text-slate-700">{{ $laporan->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                </div>

                                <div class="md:w-1/3 bg-blue-50 border border-blue-100 rounded-[1.2rem] p-5 flex flex-col justify-center items-center text-center">
                                    <p class="text-[10px] font-black uppercase text-blue-500 mb-2 leading-none">Lampiran Bukti:</p>
                                    @if($laporan->lampiran)
                                        <a href="{{ asset('storage/' . $laporan->lampiran) }}" target="_blank" class="flex flex-col items-center group">
                                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform border border-blue-100">
                                                <i data-lucide="image" class="w-5 h-5"></i>
                                            </div>
                                            <span class="text-[10px] font-bold text-blue-600 mt-2 hover:underline">Klik Lihat Foto</span>
                                        </a>
                                    @else
                                        <i data-lucide="image-off" class="w-8 h-8 text-slate-300"></i>
                                        <span class="text-[10px] font-bold text-slate-400 mt-1 italic">Tanpa Lampiran</span>
                                    @endif
                                </div>
                            </div>

                            @if($laporan->status !== 'selesai')
                            <div class="flex justify-end">
                                <form action="{{ route('admin.laporan.updateStatus', $laporan->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" onclick="return confirm('Selesaikan aduan ini?')" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-black rounded-lg uppercase tracking-widest flex items-center gap-2 transition-all shadow-lg shadow-emerald-200">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i> Tandai Selesai
                                    </button>
                                </form>
                            </div>
                            @endif

                            <div class="bg-white border border-slate-200 rounded-[1.5rem] p-5 shadow-inner max-h-64 overflow-y-auto space-y-4">
                                @forelse ($laporan->messages ?? [] as $msg)
                                    <div class="flex {{ $msg->sender === 'mahasiswa' ? 'justify-start' : 'justify-end' }}">
                                        <div class="max-w-[85%] break-words {{ $msg->sender === 'mahasiswa' ? 'bg-slate-100 text-slate-700 rounded-tl-sm' : 'bg-blue-600 text-white rounded-tr-sm' }} px-5 py-3 rounded-2xl shadow-sm text-xs font-semibold leading-relaxed">
                                            @if($msg->sender !== 'mahasiswa')
                                                <p class="text-[8px] uppercase font-black opacity-60 mb-1 tracking-widest">{{ $msg->source == 'ai' ? '🤖 AI Assistant' : '👤 Admin Utama' }}</p>
                                            @endif
                                            {!! nl2br(e($msg->message)) !!}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-xs italic text-slate-400 py-4 font-medium">Belum ada percakapan untuk tiket ini.</p>
                                @endforelse
                            </div>

                            @if($laporan->status !== 'selesai')
                            <div class="flex gap-3">
                                <form action="{{ route('admin.laporan.sendMessage', $laporan->id) }}" method="POST" class="relative flex-1">
                                    @csrf
                                    <textarea name="message" rows="2" required class="w-full pl-5 pr-28 py-4 bg-white border-2 border-slate-200 rounded-2xl text-sm font-semibold outline-none focus:border-blue-600 transition-all resize-none shadow-sm" placeholder="Ketik balasan untuk mahasiswa..."></textarea>
                                    <button type="submit" class="absolute right-2 top-2 bottom-2 px-5 bg-slate-900 hover:bg-blue-600 text-white font-black text-[10px] rounded-xl uppercase tracking-widest flex items-center gap-2 transition-all">
                                        Kirim <i data-lucide="send" class="w-3 h-3"></i>
                                    </button>
                                </form>

                                <form action="{{ route('laporan.generateResponAi', $laporan->id) }}" method="POST" class="shrink-0">
                                    @csrf
                                    <button type="submit" class="h-full px-5 bg-gradient-to-tr from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black text-[10px] rounded-2xl uppercase tracking-widest flex flex-col items-center justify-center gap-1 shadow-xl hover:scale-105 transition-all group">
                                        <i data-lucide="sparkles" class="w-5 h-5 mb-1 group-hover:animate-pulse"></i> Balas AI
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20 text-slate-400 font-bold italic border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50/50">
                        <i data-lucide="coffee" class="w-12 h-12 mx-auto mb-3 opacity-20"></i>
                        Belum ada laporan masuk...
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    @if(session('success') || session('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        Toast.fire({
            icon: "{{ session('success') ? 'success' : 'error' }}",
            title: "{!! session('success') ?? session('error') !!}"
        });
    </script>
    @endif

    <script>lucide.createIcons();</script>
</body>
</html>