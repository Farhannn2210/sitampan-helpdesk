<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aduan | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
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
        .animate-spin-slow { animation: spin 3s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .chat-markdown p { margin: 0.25rem 0; }
        .chat-markdown p:first-child { margin-top: 0; }
        .chat-markdown p:last-child { margin-bottom: 0; }
        .chat-markdown ul, .chat-markdown ol { margin: 0.25rem 0; padding-left: 1.25rem; }
        .chat-markdown ul { list-style: disc; }
        .chat-markdown ol { list-style: decimal; }
        .chat-markdown li { margin: 0.125rem 0; }
        .chat-markdown pre { white-space: pre-wrap; }
    </style>
</head>
<body class="bg-app text-slate-800 min-h-screen" x-data="{ open: false }">

    <div x-show="open" @click="open = false" x-cloak class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[60]"></div>

    <div x-show="open" x-cloak class="fixed inset-y-0 left-0 w-72 bg-slate-900 text-white z-[70] shadow-2xl flex flex-col border-r border-white/5">
        <div class="p-8 flex justify-between items-center border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30"><i data-lucide="shield-check" class="w-6 h-6 text-white"></i></div>
                <span class="font-sora font-extrabold text-xl tracking-tighter text-blue-400 italic uppercase">SITAMPAN</span>
            </div>
            <button @click="open = false" class="p-2 hover:bg-white/10 rounded-full transition"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <nav class="flex-1 px-6 py-8 space-y-3">
            <a href="/mahasiswa/dashboard" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group"><i data-lucide="layout-grid" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Beranda</a>
            <a href="/mahasiswa/buat-aduan" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group"><i data-lucide="plus-circle" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Buat Aduan Baru</a>
            <a href="/mahasiswa/riwayat" class="flex items-center p-4 bg-blue-600/20 text-blue-400 border border-blue-500/20 rounded-2xl font-bold text-sm"><i data-lucide="history" class="mr-3 w-5 h-5"></i> Riwayat Aduan</a>
            <a href="/profile" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group"><i data-lucide="user" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Profil Saya</a>
        </nav>

        <div class="p-8 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center p-4 w-full hover:bg-red-500/10 rounded-2xl transition text-red-400 font-bold text-sm group text-left"><i data-lucide="power" class="mr-3 w-5 h-5 group-hover:scale-110 transition-transform"></i> Keluar Aplikasi</button>
            </form>
        </div>
    </div>

    <div class="flex flex-col min-h-screen">
        <header class="h-20 bg-white/80 backdrop-blur-lg border-b border-slate-100 px-6 md:px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-5">
                <button @click="open = true" class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 hover:bg-slate-100 transition text-slate-600"><i data-lucide="menu" class="w-5 h-5"></i></button>
                <div class="hidden sm:block"><h1 class="font-sora font-black text-xl italic text-slate-900 tracking-tighter leading-none uppercase">SITAMPAN <span class="text-blue-600 font-light not-italic text-lg">Student</span></h1></div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right leading-none hidden md:block uppercase">
                    <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-[10px] text-blue-600 font-bold tracking-widest mt-1">{{ auth()->user()->role ?? 'Student' }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg ring-2 ring-white uppercase">{{ substr(auth()->user()->name ?? 'MH', 0, 2) }}</div>
            </div>
        </header>

        <main class="p-6 md:p-10 max-w-6xl mx-auto w-full space-y-8">
            <div class="bg-slate-900 rounded-[2rem] p-8 md:p-10 text-white shadow-xl relative overflow-hidden border border-slate-800">
                <div class="relative z-10">
                    <h2 class="text-3xl font-sora font-extrabold tracking-tight">Riwayat Aduan 🗂️</h2>
                    <p class="text-slate-400 mt-2 text-sm font-medium uppercase tracking-wide">Pantau perkembangan laporan Anda di sini.</p>
                </div>
            </div>

            @php
                $totalAduan = count($laporans ?? []);
                $totalProses = collect($laporans ?? [])->where('status', 'diproses')->count();
                $totalSelesai = collect($laporans ?? [])->where('status', 'selesai')->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600"><i data-lucide="file-text"></i></div>
                    <div><p class="text-[10px] font-black text-slate-400 uppercase">Total Tiket</p><h3 class="text-2xl font-sora font-bold text-slate-800">{{ sprintf('%02d', $totalAduan) }}</h3></div>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500"><i data-lucide="loader-2" class="animate-spin-slow"></i></div>
                    <div><p class="text-[10px] font-black text-slate-400 uppercase">Diproses</p><h3 class="text-2xl font-sora font-bold text-slate-800">{{ sprintf('%02d', $totalProses) }}</h3></div>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500"><i data-lucide="check-circle-2"></i></div>
                    <div><p class="text-[10px] font-black text-slate-400 uppercase">Selesai</p><h3 class="text-2xl font-sora font-bold text-slate-800">{{ sprintf('%02d', $totalSelesai) }}</h3></div>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($laporans as $laporan)
                    @php
                        // Konfigurasi warna berdasar status
                        $theme = match($laporan->status) {
                            'baru' => ['color' => 'blue', 'text' => 'Terkirim', 'icon' => 'send'],
                            'diproses' => ['color' => 'amber', 'text' => 'Diproses', 'icon' => 'loader-2'],
                            'selesai' => ['color' => 'emerald', 'text' => 'Selesai', 'icon' => 'check-circle'],
                            default => ['color' => 'slate', 'text' => 'Unknown', 'icon' => 'alert-circle']
                        };
                    @endphp

                    <div x-data="{ openDetail: false }" class="bg-white p-6 md:p-8 rounded-[1.5rem] border border-slate-200 border-l-[6px] border-l-{{ $theme['color'] }}-500 shadow-sm hover:shadow-md transition-all flex flex-col group overflow-hidden">
                        
                        <div class="flex flex-col md:flex-row justify-between items-center w-full gap-4">
                            <div class="flex gap-5 w-full md:w-auto items-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-{{ $theme['color'] }}-50 text-{{ $theme['color'] }}-500 border border-{{ $theme['color'] }}-100 shrink-0">
                                    <i data-lucide="{{ $theme['icon'] }}" class="{{ $laporan->status == 'diproses' ? 'animate-spin-slow' : '' }} w-5 h-5"></i>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black uppercase px-2 py-1 rounded-md bg-{{ $theme['color'] }}-50 text-{{ $theme['color'] }}-600">{{ $laporan->kategori }}</span>
                                    <h3 class="font-bold text-slate-800 text-lg mt-1">"{{ $laporan->subjek }}"</h3>
                                    <p class="text-xs text-slate-500 mt-0.5">Tiket: #TP-{{ $laporan->id + 100 }} • {{ $laporan->created_at->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-3 w-full md:w-auto">
                                <span class="px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest bg-{{ $theme['color'] }}-500 text-white shadow-md">{{ $theme['text'] }}</span>
                                
                                <button @click="openDetail = !openDetail" class="text-xs font-bold text-blue-500 hover:text-blue-700 transition-colors uppercase tracking-widest flex items-center gap-1">
                                    <span x-text="openDetail ? 'TUTUP DETAIL' : 'DETAIL ADUAN'"></span>
                                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="openDetail ? 'rotate-180' : ''"></i>
                                </button>
                            </div>
                        </div>

                        <div x-cloak x-show="openDetail" x-collapse x-transition class="mt-6 pt-6 border-t border-slate-100 w-full space-y-4">
                            
                            <div class="bg-slate-50/50 border border-slate-200 rounded-[1.5rem] p-5 shadow-inner max-h-80 overflow-y-auto space-y-4">
                                @forelse ($laporan->messages ?? [] as $msg)
                                    <div class="flex {{ $msg->sender === 'mahasiswa' ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[85%] break-words px-5 py-3 shadow-sm text-sm font-medium leading-relaxed
                                            {{ $msg->sender === 'mahasiswa' 
                                                ? 'bg-blue-600 text-white rounded-[1.5rem] rounded-tr-sm' 
                                                : 'bg-white border border-slate-200 text-slate-700 rounded-[1.5rem] rounded-tl-sm' }}">
                                            
                                            @if($msg->sender !== 'mahasiswa')
                                                <div class="text-[9px] font-black uppercase tracking-widest mb-1 {{ $msg->source == 'ai' ? 'text-indigo-500' : 'text-slate-400' }} flex items-center gap-1">
                                                    @if($msg->source == 'ai') <i data-lucide="sparkles" class="w-3 h-3"></i> Admin AI @else <i data-lucide="shield-check" class="w-3 h-3"></i> Admin Utama @endif
                                                </div>
                                            @endif

                                            @if($msg->source === 'ai')
                                                <div class="chat-markdown">{!! \Illuminate\Support\Str::markdown($msg->message, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>
                                            @else
                                                {!! nl2br(e($msg->message)) !!}
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-xs italic text-slate-400 py-4 font-medium">Belum ada percakapan untuk tiket ini.</p>
                                @endforelse
                            </div>

                            @if($laporan->status != 'selesai')
                            <form action="{{ route('laporan.mahasiswaSendMessage', $laporan->id) }}" method="POST" class="relative">
                                @csrf
                                <textarea name="message" rows="2" required class="w-full pl-5 pr-28 py-4 bg-white border-2 border-slate-200 rounded-2xl text-sm font-semibold outline-none focus:border-blue-600 transition-all resize-none shadow-sm" placeholder="Balas pesan admin di sini..."></textarea>
                                <button type="submit" class="absolute right-2 top-2 bottom-2 px-5 bg-blue-600 hover:bg-blue-700 text-white font-black text-[10px] rounded-xl uppercase tracking-widest flex items-center gap-2 transition-all">
                                    Kirim <i data-lucide="send" class="w-3 h-3"></i>
                                </button>
                            </form>
                            @else
                                <div class="text-center p-3 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-xl border border-emerald-100 uppercase tracking-widest">
                                    <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-1"></i> Tiket Ini Telah Diselesaikan
                                </div>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="text-center py-16 bg-white rounded-[2rem] border border-slate-100">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300"><i data-lucide="inbox" class="w-10 h-10"></i></div>
                        <p class="text-slate-400 font-medium">Belum ada riwayat pengaduan yang Anda buat.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    @if(session('success') || session('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, timerProgressBar: true
        });
        Toast.fire({ icon: "{{ session('success') ? 'success' : 'error' }}", title: "{!! session('success') ?? session('error') !!}" });
    </script>
    @endif
    <script>lucide.createIcons();</script>
</body>
</html>