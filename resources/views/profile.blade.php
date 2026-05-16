<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
        .bg-app { background-color: #F8FAFC; background-image: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.05) 0px, transparent 50%); }
    </style>
</head>
<body class="bg-app min-h-screen text-slate-800">
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 px-6 flex items-center justify-between sticky top-0 z-50 shadow-sm">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('mahasiswa.dashboard') }}" class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 hover:bg-slate-100 transition text-slate-600">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="font-sora font-extrabold text-slate-900 uppercase tracking-tighter italic">SITAMPAN <span class="text-blue-600 font-light not-italic">Profile</span></h1>
        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold uppercase shadow-lg">{{ substr(auth()->user()->name, 0, 2) }}</div>
    </header>

    <main class="max-w-3xl mx-auto py-12 px-6">
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
            <div class="h-40 bg-gradient-to-r from-slate-900 to-blue-800 relative">
                <div class="absolute -bottom-16 left-8 flex items-end gap-6">
                    <div class="w-32 h-32 bg-white p-2 rounded-[2.5rem] shadow-2xl">
                        <div class="w-full h-full bg-slate-100 rounded-[2rem] flex items-center justify-center text-blue-600 border border-slate-50"><i data-lucide="user" class="w-12 h-12"></i></div>
                    </div>
                </div>
            </div>

            <div class="pt-20 pb-10 px-10 border-b border-slate-50">
                <h2 class="text-3xl font-sora font-black text-slate-900">{{ auth()->user()->name }}</h2>
                <div class="flex items-center gap-2 mt-2">
                    <span class="px-3 py-1 {{ auth()->user()->role === 'admin' ? 'bg-indigo-100 text-indigo-600 border-indigo-200' : 'bg-blue-100 text-blue-600 border-blue-200' }} text-[10px] font-black uppercase tracking-widest rounded-lg border">
                        {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Mahasiswa' }}
                    </span>
                    <span class="text-slate-400 text-xs font-medium italic">Terdaftar sejak {{ auth()->user()->created_at->format('M Y') }}</span>
                </div>
            </div>

            <div class="p-10 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 flex items-center gap-2"><i data-lucide="fingerprint" class="w-3 h-3"></i> ID / NIM</label>
                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 font-bold text-slate-700 shadow-inner uppercase tracking-wider">{{ auth()->user()->nim ?? auth()->user()->username ?? 'N/A' }}</div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 flex items-center gap-2"><i data-lucide="mail" class="w-3 h-3"></i> Email</label>
                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 font-bold text-slate-700 shadow-inner lowercase">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="bg-amber-50 rounded-3xl p-6 border border-amber-100 flex items-start gap-4">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-amber-500 shadow-sm shrink-0"><i data-lucide="info" class="w-5 h-5"></i></div>
                    <div>
                        <h4 class="font-bold text-amber-900 text-sm uppercase tracking-tighter italic">Informasi Akun</h4>
                        <p class="text-amber-800/70 text-xs mt-1 leading-relaxed">Penyalahgunaan akun dapat mengakibatkan pemblokiran akses sistem SITAMPAN secara permanen.</p>
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('profile.edit') }}" class="flex-1 py-5 bg-slate-900 hover:bg-blue-600 text-white rounded-2xl font-sora font-black text-xs uppercase tracking-widest transition-all shadow-xl text-center block">Edit Profil</a>
                    <form action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-5 bg-white border-2 border-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-2xl font-sora font-black text-xs uppercase tracking-widest transition-all">Keluar Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>lucide.createIcons();</script>
</body>
</html>