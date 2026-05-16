<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SITAMPAN Helpdesk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Sora:wght@400;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
        .bg-mesh {
            background-color: #f8fafc;
            background-image: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.05) 0px, transparent 50%), 
                              radial-gradient(at 100% 100%, rgba(29, 78, 216, 0.05) 0px, transparent 50%);
        }
    </style>
</head>
<body class="bg-mesh min-h-screen flex items-center justify-center p-6 text-slate-800">
    <div class="w-full max-w-[450px]">
        <div class="text-center mb-10">
            <div class="inline-block p-4 bg-white rounded-[2rem] shadow-xl shadow-blue-100 mb-6 border border-slate-50">
                <img src="{{ asset('img/Logo Untad Baru.png') }}" alt="Logo UNTAD" class="h-20 w-auto">
            </div>
            <h1 class="font-sora font-black text-3xl text-slate-900 tracking-tighter italic leading-none">
                SITAMPAN <span class="text-blue-600 font-light not-italic text-2xl">Helpdesk</span>
            </h1>
        </div>

        <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[3rem] shadow-2xl border border-white" x-data="{ showPass: false }">
            <h2 class="font-sora font-bold text-xl text-slate-800 mb-6 text-center uppercase tracking-tight">Selamat Datang</h2>
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl text-xs font-bold text-center">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-xs font-bold text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-1">
                    <label class="block text-[10px] font-black text-slate-400 uppercase ml-1">Username / NIM</label>
                    <input type="text" name="username" required value="{{ old('username') }}"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all font-semibold" 
                        placeholder="NIM atau Admin ID">
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between items-center px-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                    </div>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" required 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all font-semibold" 
                            placeholder="••••••••">
                        
                        <button type="button" @click="showPass = !showPass" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 transition z-10">
                            <i x-show="!showPass" data-lucide="eye" class="w-5 h-5"></i>
                            <i x-show="showPass" data-lucide="eye-off" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-sora font-bold py-4 rounded-2xl shadow-lg transition-all uppercase tracking-widest text-xs">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100/50">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 text-center">Belum Punya Akun?</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="flex items-center gap-2 text-blue-600 font-bold text-xs hover:text-blue-800 transition-colors">
                        <i data-lucide="graduation-cap" class="w-4 h-4"></i> Daftar Mahasiswa
                    </a>
                    <a href="{{ route('register.admin') }}" class="flex items-center gap-2 text-slate-600 font-bold text-xs hover:text-blue-600 transition-colors">
                        <i data-lucide="user-cog" class="w-4 h-4"></i> Daftar Admin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>