<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SITAMPAN Helpdesk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .font-sora { font-family: 'Sora', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4 relative overflow-hidden bg-slate-50">
    
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="z-10 w-full max-w-md flex flex-col items-center">
        <img src="{{ asset('img/Logo Untad Baru.png') }}" alt="Logo UNTAD" class="w-20 h-20 mb-4 drop-shadow-lg transition-transform hover:scale-105 duration-300">
        <h1 class="font-sora text-3xl font-extrabold text-slate-900 mb-1 tracking-tight">SITAMPAN<span class="font-light text-blue-600">Helpdesk</span></h1>
        <p class="text-slate-500 text-sm mb-8 text-center font-medium">Sistem Layanan Pengaduan Terpadu Mahasiswa</p>

        <div class="bg-white/80 backdrop-blur-xl w-full rounded-[2.5rem] p-8 md:p-10 shadow-2xl shadow-slate-200/50 border border-white">
            <h2 class="text-center font-bold text-slate-800 text-lg mb-6 uppercase tracking-widest">Selamat Datang</h2>

            @if(session('success'))
                <div class="bg-emerald-50 text-emerald-600 px-4 py-3.5 rounded-2xl text-xs font-bold text-center mb-6 border border-emerald-100 flex items-center justify-center gap-2">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 text-red-600 px-4 py-3.5 rounded-2xl text-xs font-bold text-center mb-6 border border-red-100 flex items-center justify-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Username / NIM</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                        </div>
                        <input type="text" name="username" required placeholder="Masukkan NIM..." class="w-full pl-11 pr-4 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-blue-600 rounded-2xl outline-none transition-all text-sm font-semibold text-slate-700 shadow-inner">
                    </div>
                </div>

                <div x-data="{ show: false }">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="••••••••" class="w-full pl-11 pr-12 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-blue-600 rounded-2xl outline-none transition-all text-sm font-bold text-slate-700 tracking-widest shadow-inner">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 transition-colors focus:outline-none">
                            <i data-lucide="eye" x-show="show" x-cloak class="w-5 h-5"></i>
                            <i data-lucide="eye-off" x-show="!show" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 mt-2 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-1">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 text-center border-t border-slate-100 pt-6">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4">Belum Punya Akun?</p>
                <div class="flex items-center justify-center gap-5 text-[11px] font-bold">
                    <a href="{{ route('register') }}" class="text-slate-500 hover:text-blue-600 flex items-center gap-1.5 transition-colors"><i data-lucide="user-plus" class="w-4 h-4"></i> Daftar Mahasiswa</a>
                    <span class="text-slate-300">|</span>
                    <a href="{{ route('register.admin') }}" class="text-slate-500 hover:text-blue-600 flex items-center gap-1.5 transition-colors"><i data-lucide="shield" class="w-4 h-4"></i> Daftar Admin</a>
                </div>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>