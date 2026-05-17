<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya | SITAMPAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fe; }
        .font-sora { font-family: 'Sora', sans-serif; }
    </style>
</head>
<body class="text-slate-800 min-h-screen flex flex-col">

    <header class="h-20 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30">
        <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('mahasiswa.dashboard') }}" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-colors font-semibold text-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Dashboard
        </a>
        <h1 class="font-sora font-bold text-lg text-slate-800 hidden sm:block">Profil <span class="text-blue-600">Pengguna</span></h1>
        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-600 font-bold border border-slate-200">{{ substr(auth()->user()->name ?? 'US', 0, 2) }}</div>
    </header>

    <main class="flex-1 p-6 md:p-10 flex items-center justify-center">
        <div class="w-full max-w-xl">
            
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden relative">
                <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-600 w-full relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>

                <div class="px-8 pb-8">
                    <div class="relative -mt-16 mb-4 flex justify-center">
                        <div class="w-32 h-32 bg-white rounded-full p-2 shadow-lg">
                            <div class="w-full h-full bg-gradient-to-tr {{ auth()->user()->role == 'admin' ? 'from-slate-800 to-slate-600' : 'from-blue-600 to-blue-400' }} rounded-full flex items-center justify-center text-white text-4xl font-black shadow-inner">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-sora font-extrabold text-slate-900">{{ auth()->user()->name }}</h2>
                        <span class="inline-block mt-2 px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest {{ auth()->user()->role == 'admin' ? 'bg-slate-900 text-white' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">
                            {{ auth()->user()->role == 'admin' ? 'Administrator SITAMPAN' : 'Mahasiswa' }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-400"><i data-lucide="user" class="w-5 h-5"></i></div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Username / NIM</p>
                                <p class="text-sm font-bold text-slate-700">{{ auth()->user()->username ?? auth()->user()->nim ?? '-' }}</p>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-400"><i data-lucide="calendar" class="w-5 h-5"></i></div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Bergabung Sejak</p>
                                <p class="text-sm font-bold text-slate-700">{{ auth()->user()->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white rounded-xl font-bold text-sm transition-colors border border-red-100 flex justify-center items-center gap-2">
                                <i data-lucide="power" class="w-4 h-4"></i> Keluar dari Sistem
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>