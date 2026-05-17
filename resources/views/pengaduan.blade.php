<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Aduan Baru | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fe; }
        .font-sora { font-family: 'Sora', sans-serif; }
        [x-cloak] { display: none !important; }
        .swal2-popup { border-radius: 1.5rem !important; font-family: 'Inter', sans-serif !important; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        .animate-shake { animation: shake 0.2s ease-in-out 0s 2; }
    </style>
</head>
<body class="text-slate-800 min-h-screen flex flex-col" x-data="{ isSubmitting: false, fileName: '', fileSize: 0 }">

    <header class="h-20 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30">
        <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-colors font-semibold text-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
        <h1 class="font-sora font-bold text-lg text-slate-800 hidden sm:block">Buat Tiket <span class="text-blue-600">Aduan</span></h1>
        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-600 font-bold border border-slate-200">{{ substr(auth()->user()->name ?? 'MH', 0, 2) }}</div>
    </header>

    <main class="flex-1 p-6 md:p-10 flex items-center justify-center">
        <div class="w-full max-w-3xl">
            
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4"><i data-lucide="pen-tool" class="w-6 h-6"></i></div>
                <h2 class="text-3xl font-sora font-extrabold text-slate-900 mb-2">Form Pengaduan</h2>
                <p class="text-slate-500 text-sm">Isi form di bawah ini dengan jelas agar tim helpdesk dapat segera merespon.</p>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/40">
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-xs font-semibold">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form id="formAduan" action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" @submit="isSubmitting = true">
                    @csrf
                    
                    <div class="space-y-2" x-data="{ selectOpen: false, selected: '{{ old('kategori') }}', options: ['Layanan Akademik', 'Fasilitas Kampus', 'Sistem Informasi / IT', 'Lain-lain'] }">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 ml-1">Kategori Masalah <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="hidden" id="inputKategori" name="kategori" :value="selected" required>
                            <button type="button" @click="selectOpen = !selectOpen" class="w-full pl-5 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all text-left text-sm font-medium text-slate-700">
                                <span x-text="selected ? selected : '-- Pilih Kategori --'"></span>
                                <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" :class="selectOpen ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <div x-show="selectOpen" @click.outside="selectOpen = false" x-cloak x-transition class="absolute left-0 right-0 mt-1 bg-white border border-slate-200 rounded-xl shadow-lg z-50 overflow-hidden py-1">
                                <template x-for="option in options">
                                    <div @click="selected = option; selectOpen = false" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 cursor-pointer text-sm font-medium text-slate-600 transition-colors">
                                        <span x-text="option"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 ml-1">Subjek Laporan <span class="text-red-500">*</span></label>
                        <input type="text" name="subjek" value="{{ old('subjek') }}" required placeholder="Contoh: AC Kelas Rusak / Error Siakad" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all outline-none text-sm font-medium text-slate-700">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 ml-1">Detail Kronologi <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi" rows="6" required placeholder="Ceritakan secara detail kronologi atau masalah yang Anda alami..." class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all outline-none text-sm font-medium text-slate-700 resize-none">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 ml-1 flex justify-between">
                            <span>Bukti Foto <span class="text-slate-400 font-normal lowercase tracking-normal">(Opsional)</span></span>
                            <span class="text-blue-500">Maks. 10MB</span>
                        </label>
                        
                        <label class="relative block w-full cursor-pointer">
                            <input type="file" name="lampiran" class="hidden" accept="image/*" @change="if($event.target.files[0]){ fileName = $event.target.files[0].name; fileSize = ($event.target.files[0].size/1024/1024).toFixed(2); }">
                            <div class="border-2 border-dashed border-slate-300 hover:border-blue-500 bg-slate-50 hover:bg-blue-50/50 rounded-2xl p-8 transition-colors flex flex-col items-center justify-center gap-3">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-200 text-slate-400">
                                    <i data-lucide="upload-cloud" class="w-5 h-5" x-show="!fileName"></i>
                                    <i data-lucide="check" class="w-5 h-5 text-emerald-500" x-show="fileName" x-cloak></i>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-semibold text-slate-700" x-text="fileName ? fileName : 'Klik untuk unggah foto'"></p>
                                    <p class="text-[10px] text-slate-500 mt-1" x-text="fileName ? fileSize + ' MB' : 'Format didukung: JPG, PNG'"></p>
                                </div>
                            </div>
                        </label>

                        <template x-if="fileSize > 10">
                            <div class="p-3 bg-red-50 border border-red-100 rounded-lg flex items-center gap-2 text-red-600 animate-shake mt-2">
                                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                                <p class="text-xs font-bold">Ukuran file terlalu besar! Maksimal 10MB.</p>
                            </div>
                        </template>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit" :disabled="isSubmitting || fileSize > 10" class="w-full py-4 bg-slate-900 hover:bg-blue-600 text-white rounded-xl font-bold text-sm uppercase tracking-wider transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isSubmitting">Kirim Laporan</span>
                            <span x-show="isSubmitting" class="flex items-center gap-2"><i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
        document.getElementById('formAduan').addEventListener('submit', function(e) {
            const kategori = document.getElementById('inputKategori').value;
            if (!kategori) {
                e.preventDefault();
                Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Pilih Kategori keluhan terlebih dahulu!', confirmButtonColor: '#3b82f6' });
                window.dispatchEvent(new CustomEvent('reset-submit'));
                return;
            }
            e.preventDefault();
            Swal.fire({
                title: 'Kirim Laporan?',
                text: "Pastikan data yang diisi sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0f172a',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Kirim',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Memproses...', showConfirmButton: false, didOpen: () => { Swal.showLoading(); }});
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