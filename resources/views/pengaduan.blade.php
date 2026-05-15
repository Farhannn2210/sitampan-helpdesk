<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Laporan | SITAMPAN Helpdesk UNTAD</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Sora:wght@400;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
        .bg-portal {
            background-color: #F8FAFC;
            background-image: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.08) 0px, transparent 50%), 
                              radial-gradient(at 100% 100%, rgba(30, 58, 138, 0.05) 0px, transparent 50%);
        }
        textarea::-webkit-scrollbar { width: 6px; }
        textarea::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
    </style>
</head>
<body class="bg-portal min-h-screen text-slate-800 p-6 md:p-12">

    <div class="max-w-4xl mx-auto relative">
        <div class="flex items-center justify-between mb-10">
            <a href="/mahasiswa/dashboard" class="group flex items-center gap-3 bg-white px-6 py-3.5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300">
                <i data-lucide="chevron-left" class="w-5 h-5 text-slate-500 group-hover:text-blue-600 group-hover:-translate-x-1 transition-all"></i>
                <span class="text-sm font-bold text-slate-700">Kembali ke Beranda</span>
            </a>
            <div class="text-right">
                <h1 class="font-sora font-black text-2xl text-slate-900 tracking-tighter italic leading-none">
                    SITAMPAN <span class="text-blue-600 font-light not-italic">Helpdesk</span>
                </h1>
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.3em] mt-2">Portal Pengaduan Mahasiswa</p>
            </div>
        </div>

        <div class="bg-white rounded-[3rem] shadow-2xl shadow-blue-900/10 border border-white overflow-hidden">
            <div class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 px-10 py-14 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="font-sora font-extrabold text-4xl tracking-tight leading-tight">Sampaikan Kendalamu 👋</h2>
                    <p class="text-blue-100/80 text-sm mt-3 max-w-md font-medium leading-relaxed">Tuliskan permasalahanmu secara rinci. Kami menjamin kerahasiaan identitas dan keamanan datamu.</p>
                </div>
                <img src="{{ asset('img/Logo Untad Baru-jukebox-bg-removed.jpg') }}" class="absolute right-[-5%] bottom-[-20%] w-72 opacity-10 grayscale invert rotate-12 pointer-events-none">
            </div>

            <div class="p-8 md:p-14">
                <form id="complaintForm" class="space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em] ml-1 block">Kategori Pelaporan <span class="text-red-500">*</span></label>
                            <select class="w-full pl-6 pr-12 py-4 bg-white border-2 border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 outline-none transition-all appearance-none shadow-sm">
                                <option>Layanan Akademik & KRS</option>
                                <option>Kendala Sistem SIRENA</option>
                                <option>Fasilitas Gedung/Lab</option>
                                <option>Keluhan Umum Kampus</option>
                            </select>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em] ml-1 block">Subjek Laporan <span class="text-red-500">*</span></label>
                            <input type="text" placeholder="Contoh: Lampu Ruang Kuliah Mati" class="w-full px-6 py-4 bg-white border-2 border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 outline-none shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em] ml-1 block">Kronologi / Deskripsi Masalah <span class="text-red-500">*</span></label>
                        <textarea rows="7" placeholder="Jelaskan secara detail masalah yang kamu hadapi..." class="w-full px-6 py-5 bg-white border-2 border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 outline-none resize-none shadow-sm"></textarea>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em] ml-1 block text-nowrap">Lampiran Foto Bukti <span class="text-slate-400 font-medium italic lowercase">(opsional)</span></label>
                        <div class="group relative border-2 border-dashed border-slate-300 rounded-[2.5rem] p-12 flex flex-col items-center justify-center bg-slate-50/50 hover:bg-blue-50 transition-all cursor-pointer">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md mb-5"><i data-lucide="image-plus" class="w-8 h-8 text-blue-600"></i></div>
                            <p class="text-sm font-bold text-slate-800">Klik untuk upload foto bukti</p>
                            <p class="text-[10px] text-slate-500 mt-2 font-black uppercase tracking-widest">PNG, JPG, PDF • MAKS 5MB</p>
                            <input type="file" class="hidden">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-blue-700 text-white font-sora font-extrabold py-5 rounded-2xl shadow-xl transition-all flex items-center justify-center gap-4">
                        <i data-lucide="send" class="w-6 h-6"></i>
                        <span class="tracking-[0.1em] text-sm">KIRIM ADUAN SEKARANG</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        document.getElementById('complaintForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Berhasil!',
                text: 'Laporanmu sudah dikirim ke sistem.',
                icon: 'success',
                confirmButtonColor: '#1E40AF'
            }).then(() => {
                window.location.href = "/mahasiswa/dashboard";
            });
        });
    </script>
</body>
</html>