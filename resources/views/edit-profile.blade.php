<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
        .bg-app { background-color: #F8FAFC; background-image: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.05) 0px, transparent 50%); }
    </style>
</head>
<body class="bg-app min-h-screen">
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 px-6 flex items-center justify-between sticky top-0 z-50 shadow-sm">
        <a href="{{ route('profile') }}" class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 hover:bg-slate-100 transition text-slate-600">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="font-sora font-extrabold text-slate-900 uppercase tracking-tighter italic">Edit <span class="text-blue-600">Profile</span></h1>
        <div class="w-10 h-10 opacity-0"></div> </header>

    <main class="max-w-2xl mx-auto py-12 px-6">
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden p-8 md:p-12">
            <div class="text-center mb-10">
                <div class="w-24 h-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-lg">
                    <i data-lucide="user-pen" class="w-10 h-10"></i>
                </div>
                <h2 class="text-2xl font-sora font-black text-slate-900">Perbarui Data Diri</h2>
                <p class="text-xs text-slate-500 mt-2">Pastikan data yang Anda masukkan sesuai dengan data akademik UNTAD.</p>
            </div>

            <form action="#" method="POST" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Lengkap</label>
                    <input type="text" value="{{ auth()->user()?->name ?? '' }}" placeholder="Nama sesuai KTP/KTM" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 outline-none transition font-semibold text-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email Kampus</label>
                    <input type="email" value="{{ auth()->user()?->email ?? '' }}" placeholder="email@untad.ac.id" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 outline-none transition font-semibold text-sm">
                </div>

                <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100 flex gap-4 mt-8">
                    <i data-lucide="info" class="w-5 h-5 text-blue-500 shrink-0"></i>
                    <p class="text-xs text-blue-800 font-medium leading-relaxed">Untuk alasan keamanan, perubahan NIM / ID Pengguna hanya bisa dilakukan dengan menghubungi Admin Fakultas secara langsung.</p>
                </div>

                <div class="pt-6 border-t border-slate-100 flex gap-4">
                    <a href="{{ route('profile') }}" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-sora font-bold text-xs uppercase tracking-widest transition-all text-center">Batal</a>
                    <button type="submit" class="flex-1 py-4 bg-slate-900 hover:bg-blue-600 text-white rounded-2xl font-sora font-bold text-xs uppercase tracking-widest transition-all shadow-lg text-center">Simpan Data</button>
                </div>
            </form>
        </div>
    </main>
    <script>lucide.createIcons();</script>
</body>
</html>