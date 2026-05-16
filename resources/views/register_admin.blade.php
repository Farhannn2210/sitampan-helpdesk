<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Sora:wght@400;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
        .bg-mesh {
            background-color: #f8fafc;
            background-image: radial-gradient(at 0% 0%, rgba(30, 58, 138, 0.05) 0px, transparent 50%), 
                              radial-gradient(at 100% 100%, rgba(15, 23, 42, 0.05) 0px, transparent 50%);
        }
    </style>
</head>
<body class="bg-mesh min-h-screen flex items-center justify-center p-6 text-slate-800">
    <div class="w-full max-w-[500px]" x-data="{ show: false }">
        <div class="text-center mb-8">
            <h1 class="font-sora font-black text-3xl text-slate-900 tracking-tighter italic leading-none uppercase">
                SITAMPAN <span class="text-blue-600 font-light not-italic text-2xl">Admin</span>
            </h1>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mt-3">Registrasi Administrator</p>
        </div>

        <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[3.5rem] shadow-2xl border border-white">
            <h2 class="font-sora font-bold text-xl text-slate-800 mb-6 flex items-center gap-2">
                <i data-lucide="shield-check" class="text-blue-600"></i> Akun Admin Baru
            </h2>

            @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-600 text-xs font-bold rounded-xl border border-red-100">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.admin.post') }}" method="POST" class="space-y-5">
                @csrf 
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap Admin</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-600 outline-none font-semibold" placeholder="Contoh: Budi Santoso">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">ID Pegawai / Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-600 outline-none font-semibold" placeholder="admin_prodi_01">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-slate-400 ml-1">Password</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="password" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-600 outline-none font-semibold" placeholder="••••••">
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i x-show="!show" data-lucide="eye" class="w-4 h-4"></i>
                                <i x-show="show" data-lucide="eye-off" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-slate-400 ml-1">Ulangi</label>
                        <input :type="show ? 'text' : 'password'" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-600 outline-none font-semibold" placeholder="••••••">
                    </div>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white font-sora font-bold py-4 mt-2 rounded-2xl shadow-xl transition-all hover:bg-blue-700 active:scale-95 uppercase tracking-widest text-xs">
                    Daftar Admin
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100/50 text-center">
                <a href="{{ route('login') }}" class="text-xs font-bold text-blue-600 hover:underline">Kembali ke Login</a>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>