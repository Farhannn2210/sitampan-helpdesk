<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa | SITAMPAN</title>
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
    <div class="w-full max-w-[550px] my-10" x-data="{ show1: false, show2: false }">
        <div class="text-center mb-8">
            <h1 class="font-sora font-black text-3xl text-slate-900 tracking-tighter leading-none italic uppercase">
                SITAMPAN <span class="text-blue-600 font-light not-italic text-2xl">Helpdesk</span>
            </h1>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mt-3">Registrasi Akun Mahasiswa</p>
        </div>

        <div class="bg-white/80 backdrop-blur-xl p-8 md:p-12 rounded-[3.5rem] shadow-2xl shadow-blue-200/50 border border-white">
            <div class="mb-8">
                <h2 class="font-sora font-bold text-xl text-slate-800">Halo, Mahasiswa! 🎓</h2>
                <p class="text-xs text-slate-400 mt-1">Lengkapi data diri untuk mulai menggunakan layanan pengaduan.</p>
                
                @if($errors->any())
                <div class="mt-4 p-3 bg-red-50 text-red-600 text-xs font-bold rounded-xl border border-red-100">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all font-semibold" 
                            placeholder="Nama Sesuai KTM">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">NIM</label>
                        <input type="text" name="username" value="{{ old('username') }}" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all font-semibold" 
                            placeholder="F551...">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">Email Kampus</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all font-semibold" 
                            placeholder="email@untad.ac.id">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase ml-1">Buat Password</label>
                        <div class="relative">
                            <input :type="show1 ? 'text' : 'password'" name="password" required 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all font-semibold" 
                                placeholder="••••••">
                            <button type="button" @click="show1 = !show1" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i x-show="!show1" data-lucide="eye" class="w-4 h-4"></i>
                                <i x-show="show1" data-lucide="eye-off" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase ml-1">Ulangi Password</label>
                        <div class="relative">
                            <input :type="show2 ? 'text' : 'password'" name="password_confirmation" required 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all font-semibold" 
                                placeholder="••••••">
                            <button type="button" @click="show2 = !show2" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i x-show="!show2" data-lucide="eye" class="w-4 h-4"></i>
                                <i x-show="show2" data-lucide="eye-off" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-sora font-bold py-4 mt-2 rounded-2xl shadow-lg transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                    <i data-lucide="user-plus" class="w-4 h-4"></i> Buat Akun Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100/50 text-center">
                <p class="text-xs font-bold text-slate-500">Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 transition-all">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>