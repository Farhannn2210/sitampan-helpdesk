<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITAMPAN Helpdesk | Buat Aduan Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.05) 0px, transparent 50%), 
                              radial-gradient(at 100% 100%, rgba(30, 58, 138, 0.05) 0px, transparent 50%);
        }
        [x-cloak] { display: none !important; }
        .swal2-popup { border-radius: 2rem !important; padding: 2rem !important; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
        .animate-shake { animation: shake 0.2s ease-in-out 0s 2; }
    </style>
</head>
<body class="bg-pattern min-h-screen text-slate-800" x-data="{ open: false, isSubmitting: false, fileName: '', fileSize: 0 }">

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
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group">
                <i data-lucide="layout-grid" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Beranda
            </a>
            <a href="{{ route('mahasiswa.buat-aduan') }}" class="flex items-center p-4 bg-blue-600/20 text-blue-400 border border-blue-500/20 rounded-2xl font-bold text-sm">
                <i data-lucide="plus-circle" class="mr-3 w-5 h-5"></i> Buat Aduan Baru
            </a>
            <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group">
                <i data-lucide="history" class="mr-3 w-5 h-5 group-hover:text-blue-400"></i> Riwayat Aduan
            </a>
            <a href="{{ route('profile') }}" class="flex items-center p-4 hover:bg-white/5 rounded-2xl transition text-slate-400 hover:text-white group">
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

    <header class="h-20 bg-white/80 backdrop-blur-lg border-b border-slate-100 px-6 sm:px-10 flex items-center justify-between sticky top-0 z-30 shadow-sm">
        <button @click="open = true" class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 hover:bg-slate-100 transition text-slate-600">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="flex items-center gap-4">
            <div class="text-right leading-none uppercase hidden sm:block">
                <p class="text-sm font-bold">{{ auth()->user()->name ?? 'Mahasiswa' }}</p>
                <p class="text-[10px] text-blue-600 font-bold tracking-widest">{{ auth()->user()->role ?? 'Student' }}</p>
            </div>
            <a href="{{ route('profile') }}" class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200 ring-2 ring-white uppercase transition-transform hover:scale-105">
                {{ substr(auth()->user()->name ?? 'MH', 0, 2) }}
            </a>
        </div>
    </header>

    <main class="p-6 md:p-10 max-w-4xl mx-auto w-full">
        <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-xl relative overflow-hidden border border-slate-800">
            <div class="relative z-10">
                <h2 class="text-3xl font-sora font-extrabold tracking-tight italic">SITAMPAN <span class="font-light not-italic text-blue-400">Reports</span></h2>
                <p class="text-slate-400 mt-2 text-sm max-w-md uppercase tracking-wide">Sampaikan laporan Anda ke fakultas dengan aman.</p>
            </div>
            <div class="absolute right-0 top-0 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
        </div>

        <div class="mt-8 bg-white p-8 md:p-12 rounded-[2.5rem] border border-slate-100 shadow-xl">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl text-red-700 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formAduan" action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" @submit="isSubmitting = true">
                @csrf
                
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Subjek Aduan</label>
                    <div class="relative">
                        <i data-lucide="tag" class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                        <input type="text" name="subjek" value="{{ old('subjek') }}" required placeholder="Gagal KRS, Fasilitas Rusak..." class="w-full pl-14 pr-6 py-5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 outline-none transition font-semibold shadow-sm">
                    </div>
                </div>

                <div class="space-y-3" x-data="{ selectOpen: false, selected: '{{ old('kategori') }}', options: ['Layanan Akademik', 'Fasilitas Kampus', 'Sistem Informasi / IT', 'Lain-lain'] }">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Kategori Keluhan</label>
                    <div class="relative">
                        <input type="hidden" id="inputKategori" name="kategori" :value="selected" required>
                        <button type="button" @click="selectOpen = !selectOpen" class="w-full pl-14 pr-6 py-5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 transition font-semibold text-left flex items-center justify-between shadow-sm">
                            <span x-text="selected ? selected : 'Pilih Kategori...'" :class="selected ? 'text-slate-900' : 'text-slate-400'"></span>
                            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform" :class="selectOpen ? 'rotate-180' : ''"></i>
                        </button>
                        <i data-lucide="layers" class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                        
                        <div x-show="selectOpen" @click.outside="selectOpen = false" x-cloak x-transition class="absolute left-0 right-0 mt-2 bg-white border border-slate-100 rounded-2xl shadow-2xl z-50 overflow-hidden py-2">
                            <template x-for="option in options">
                                <div @click="selected = option; selectOpen = false" 
                                     class="px-6 py-4 hover:bg-blue-50 hover:text-blue-700 cursor-pointer transition font-semibold text-slate-600 text-sm flex items-center justify-between">
                                    <span x-text="option"></span>
                                    <i data-lucide="check" class="w-4 h-4 text-blue-600" x-show="selected === option"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Deskripsi Detail</label>
                    <textarea name="deskripsi" rows="5" required placeholder="Jelaskan detail kendala Anda..." class="w-full p-6 bg-slate-50 border border-slate-200 rounded-3xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 outline-none transition font-medium shadow-sm resize-none">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 flex justify-between items-center px-1">
                        <span>Lampiran Bukti (Opsional)</span>
                        <span class="text-blue-500">Maks. 10 MB</span>
                    </label>
                    
                    <label class="relative group cursor-pointer block">
                        <input type="file" name="lampiran" class="hidden" 
                               accept="image/*"
                               @change="
                                if ($event.target.files[0]) {
                                    fileName = $event.target.files[0].name; 
                                    fileSize = ($event.target.files[0].size / 1024 / 1024).toFixed(2);
                                }
                               ">
                        
                        <div class="border-2 border-dashed border-slate-200 group-hover:border-blue-400 group-hover:bg-blue-50/30 rounded-[2rem] p-10 transition-all duration-300 flex flex-col items-center justify-center gap-4 bg-slate-50/50">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-blue-600 transition-all shadow-sm border border-slate-100 group-hover:scale-110">
                                <i data-lucide="upload-cloud" class="w-8 h-8" x-show="!fileName"></i>
                                <i data-lucide="file-check" class="w-8 h-8 text-emerald-500" x-show="fileName" x-cloak></i>
                            </div>
                            
                            <div class="text-center">
                                <p class="text-sm font-bold text-slate-700" x-text="fileName ? fileName : 'Klik atau Seret File ke Sini'"></p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1.5" 
                                   x-text="fileName ? 'Ukuran: ' + fileSize + ' MB' : 'Format: JPG, PNG, atau JPEG'"></p>
                            </div>
                        </div>
                    </label>

                    <template x-if="fileSize > 10">
                        <div class="p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3 text-red-600 animate-shake">
                            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                            <p class="text-xs font-bold uppercase tracking-tight">Ukuran file terlalu besar! Maksimal 10MB saja Bang.</p>
                        </div>
                    </template>
                </div>
                <div class="pt-6 border-t border-slate-50 flex justify-end">
                    <button type="submit" :disabled="isSubmitting || fileSize > 10" class="px-10 py-5 bg-slate-900 hover:bg-blue-600 text-white rounded-2xl font-sora font-extrabold text-sm uppercase tracking-widest transition-all shadow-lg hover:shadow-blue-500/30 flex items-center gap-3 disabled:opacity-50">
                        <span x-show="!isSubmitting">Kirim Aduan</span>
                        <span x-show="isSubmitting" class="flex items-center gap-2"><i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Memproses...</span>
                        <i x-show="!isSubmitting" data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        lucide.createIcons();

        document.getElementById('formAduan').addEventListener('submit', function(e) {
            const kategori = document.getElementById('inputKategori').value;
            
            if (!kategori) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Kategori!',
                    text: 'Silakan tentukan kategori kendala Anda dulu.',
                    confirmButtonColor: '#2563EB',
                });
                window.dispatchEvent(new CustomEvent('reset-submit'));
                return;
            }

            e.preventDefault();
            Swal.fire({
                title: 'Sudah Yakin?',
                text: "Laporan akan dikirim ke tim helpdesk fakultas.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563EB',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-3xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang Mengirim...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    this.submit();
                } else {
                    window.dispatchEvent(new CustomEvent('reset-submit'));
                }
            });
        });

        window.addEventListener('reset-submit', () => {
            const mainEl = document.querySelector('[x-data]');
            if (mainEl.__x) mainEl.__x.$data.isSubmitting = false;
        });
    </script>
</body>
</html>