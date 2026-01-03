<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Anpundung</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="h-screen w-full bg-white overflow-hidden flex">

    <div class="hidden lg:flex w-1/2 relative bg-slate-900 flex-col justify-center overflow-hidden shadow-2xl z-10">
        
        <img src="https://images.unsplash.com/photo-1628045371660-ceb8a3db47f5?q=80&w=1974&auto=format&fit=crop" 
             class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay" 
             alt="Bandung Aesthetic">
        
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 via-blue-900/60 to-transparent"></div>

        <div class="relative z-10 px-16 w-full text-white">
            <div class="mb-6 w-20 h-1.5 bg-blue-400 rounded-full shadow-lg shadow-blue-400/50"></div>
            
            <h2 class="text-6xl font-extrabold leading-tight mb-6 tracking-tight">
                Suara Anda <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-cyan-200">Kunci Perubahan.</span>
            </h2>
            
            <p class="text-lg text-slate-200 leading-relaxed max-w-lg font-light">
                "Laporkan pungutan liar dan jadilah pahlawan bagi Kota Bandung yang lebih bersih, transparan, dan berintegritas."
            </p>
            
            <div class="mt-10 flex items-center gap-5 bg-white/5 backdrop-blur-md p-4 rounded-2xl border border-white/10 w-fit hover:bg-white/10 transition-colors cursor-default">
                <div class="bg-blue-500/20 p-2 rounded-xl">
                    <i class='bx bxs-group text-2xl text-blue-400'></i>
                </div>
                <div class="text-sm">
                    <p class="font-bold text-white">{{ number_format($userCount) }}+ Warga</p>
                    <p class="text-slate-300 text-xs">Telah bergabung & melapor.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 h-full overflow-y-auto bg-white flex flex-col items-center justify-center p-6 md:p-12 relative">
        
        <div class="absolute top-6 right-6 md:top-10 md:right-10 flex gap-2">
            <span class="text-sm text-slate-500 py-2">Belum punya akun?</span>
            <a href="{{ route('register') }}" 
                    class="px-5 py-2 rounded-full text-sm font-bold border border-slate-200 text-blue-700 hover:bg-blue-50 transition-colors">
                Daftar Sekarang
            </a>
        </div>

        <div class="w-full max-w-md">
            <div class="mb-10 flex flex-col items-start">
                <img src="{{ asset('img/logo-anpundung.png') }}" alt="Anpundung" class="h-14 w-auto mb-4">
                <h1 class="text-3xl font-bold text-slate-900">Selamat Datang</h1>
                <p class="text-slate-500 mt-2 text-base">Silakan masuk untuk mengelola laporan anda.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 text-red-600 px-4 py-3 rounded-xl text-sm font-medium border border-red-100 flex items-center gap-2">
                    <i class='bx bxs-error-circle text-lg'></i>
                    <span>Email atau password salah.</span>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-6 bg-green-50 text-green-600 px-4 py-3 rounded-xl text-sm font-medium border border-green-100 flex items-center gap-2">
                    <i class='bx bxs-check-circle text-lg'></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="group">
                    <x-input-label value="Email Address" />
                    <x-text-input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" class="px-5 py-4" required />
                </div>

                <div class="group">
                    <div class="flex justify-between items-center mb-1">
                        <x-input-label value="Password" />
                        <a href="{{ route('password.request') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">Lupa Password?</a>
                    </div>
                    <x-text-input type="password" name="password" placeholder="••••••••" class="px-5 py-4" required />
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 hover:shadow-blue-600/40 transition-all transform hover:-translate-y-0.5 active:scale-95 flex justify-center items-center gap-2 mt-4">
                    Masuk
                    <i class='bx bx-right-arrow-alt text-xl'></i>
                </button>
                
                <div class="relative flex py-4 items-center">
                    <div class="flex-grow border-t border-slate-100"></div>
                    <span class="flex-shrink-0 mx-4 text-slate-400 text-xs">Aplikasi Anti Pungli Bandung</span>
                    <div class="flex-grow border-t border-slate-100"></div>
                </div>
            </form>

        </div>

        <div class="mt-12 text-center lg:hidden">
            <p class="text-xs text-slate-400">© 2024 Anpundung Project</p>
        </div>
    </div>

</body>
</html>