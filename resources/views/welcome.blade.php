<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SITAMPAN Helpdesk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Sora:wght@400;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
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
    <div class="w-full max-w-[450px] relative">
        <div class="text-center mb-10 relative">
            <div class="inline-block p-4 bg-white rounded-[2rem] shadow-xl shadow-blue-100 mb-6 border border-slate-50 transition-transform hover:scale-105 duration-500">
                <img src="{{ asset('img/Logo Untad Baru.png') }}" alt="Logo UNTAD" class="h-20 w-auto">
            </div>
            <h1 class="font-sora font-black text-3xl text-slate-900 tracking-tighter italic leading-none italic">
                SITAMPAN <span class="text-blue-600 font-light not-italic text-2xl">Helpdesk</span>
            </h1>
        </div>

        <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[3rem] shadow-2xl border border-white">
            <h2 class="font-sora font-bold text-xl text-slate-800 mb-6">Selamat Datang</h2>
            <form id="loginForm" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">Username</label>
                    <input type="text" id="username" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="F551... atau Admin">
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2 px-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                        <a href="#" class="text-[10px] font-bold text-blue-600 hover:underline tracking-tight">Lupa Password?</a>
                    </div>
                    <input type="password" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-700 to-blue-500 text-white font-sora font-bold py-4 rounded-2xl shadow-lg hover:-translate-y-1 transition-all uppercase tracking-widest text-xs">
                    Masuk 
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100/50">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 text-center">Belum Punya Akun?</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#" class="flex items-center gap-2 text-blue-600 font-bold text-xs"><i data-lucide="graduation-cap" class="w-4 h-4"></i> Daftar Mahasiswa</a>
                    <a href="#" class="flex items-center gap-2 text-slate-600 font-bold text-xs"><i data-lucide="user-cog" class="w-4 h-4"></i> Daftar Admin</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const user = document.getElementById('username').value.toLowerCase();
            if (user.includes('f') || !isNaN(user.charAt(0))) {
                window.location.href = "/mahasiswa/dashboard";
            } else {
                window.location.href = "/admin/dashboard";
            }
        });
    </script>
</body>
</html>