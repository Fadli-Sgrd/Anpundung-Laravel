<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk & Daftar - Anpundung</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        
        .smooth-transition {
            transition-property: all;
            transition-duration: 700ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="bg-blue-50 flex justify-center items-center min-h-screen antialiased overflow-hidden text-slate-800"
      x-data="{ isSignUp: {{ request()->routeIs('register') || $errors->has('name') || $errors->has('email') && request()->is('register') ? 'true' : 'false' }} }">

    <div class="relative w-[900px] max-w-full min-h-[600px] bg-white rounded-[2rem] shadow-2xl overflow-hidden m-4 border border-blue-100">

        <div class="absolute top-0 h-full smooth-transition w-1/2 z-10"
             :class="isSignUp ? 'translate-x-[100%] opacity-100 z-50' : 'opacity-0 z-0'">
            
            <form action="{{ route('register') }}" method="POST" class="bg-white flex flex-col justify-center items-center h-full px-10 text-center">
                @csrf
                <h1 class="font-bold text-2xl mb-2 text-slate-800">Buat Akun Baru</h1>
                <p class="text-xs text-slate-500 mb-4">Bergabunglah untuk menciptakan lingkungan aman</p>

                @error('email')
                    <div class="w-full bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-4 text-xs text-left flex items-start gap-2 animate-pulse">
                        <i class='bx bxs-error-circle text-lg'></i>
                        <div>
                            <strong>Gagal Mendaftar!</strong><br>
                            {{ $message }} (Mungkin akun sudah ada?)
                        </div>
                    </div>
                @enderror
                
                <div class="w-full space-y-3">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" class="bg-slate-50 border border-slate-200 w-full py-3 px-4 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" required />
                    
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="bg-slate-50 border border-slate-200 w-full py-3 px-4 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" required />
                    
                    <div class="relative w-full" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password" placeholder="Kata Sandi" class="bg-slate-50 border border-slate-200 w-full py-3 px-4 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" required />
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600">
                            <i class='bx text-xl' :class="show ? 'bx-show' : 'bx-hide'"></i>
                        </button>
                    </div>
                    
                    <div class="relative w-full" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" class="bg-slate-50 border border-slate-200 w-full py-3 px-4 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" required />
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600">
                            <i class='bx text-xl' :class="show ? 'bx-show' : 'bx-hide'"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-blue-700 text-white text-sm font-bold uppercase py-3.5 px-10 rounded-xl tracking-wider mt-6 shadow-lg hover:bg-blue-800 transition transform active:scale-95">
                    Daftar Sekarang
                </button>
            </form>
        </div>

        <div class="absolute top-0 h-full smooth-transition left-0 w-1/2 z-20"
             :class="isSignUp ? 'translate-x-[100%] opacity-0' : 'translate-x-0 opacity-100'">
            
            <form action="{{ route('login') }}" method="POST" class="bg-white flex flex-col justify-center items-center h-full px-10 text-center">
                @csrf
                <div class="mb-4 bg-blue-100 p-3 rounded-full text-blue-600">
                    <i class='bx bxs-lock-alt text-2xl'></i>
                </div>
                <h1 class="font-bold text-2xl mb-2 text-slate-800">Selamat Datang</h1>
                <p class="text-xs text-slate-500 mb-6">Masuk untuk melaporkan atau memantau aduan</p>

                @if ($errors->any() && !request()->routeIs('register'))
                    <div class="w-full bg-red-50 text-red-600 text-xs p-3 rounded-lg mb-4 text-left border border-red-100 flex items-center gap-2">
                        <i class='bx bxs-error-circle'></i>
                        <span>Email atau kata sandi salah.</span>
                    </div>
                @endif
                
                <div class="w-full space-y-4">
                    <x-text-input type="email" name="email" value="{{ old('email') }}" placeholder="Email Anda" class="bg-slate-50 py-3 px-4" required />
                    
                    <div class="relative w-full" x-data="{ show: false }">
                        <x-text-input ::type="show ? 'text' : 'password'" name="password" placeholder="Kata Sandi" class="bg-slate-50 py-3 px-4" required />
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 cursor-pointer">
                            <i class='bx text-xl' :class="show ? 'bx-show' : 'bx-hide'"></i>
                        </button>
                    </div>
                </div>
                
                <a href="#" class="text-xs text-slate-500 font-medium mb-6 mt-3 hover:text-blue-700 transition self-end">Lupa Kata Sandi?</a>
                
                <button type="submit" class="w-full bg-blue-700 text-white text-sm font-bold uppercase py-3.5 px-10 rounded-xl tracking-wider shadow-lg hover:bg-blue-800 transition transform active:scale-95">
                    Masuk
                </button>
            </form>
        </div>

        <div class="absolute top-0 left-[50%] w-[50%] h-full overflow-hidden smooth-transition z-[100]"
             :class="isSignUp ? '-translate-x-[100%] rounded-r-[100px]' : 'rounded-l-[100px]'">
            
            <div class="bg-gradient-to-br from-blue-600 to-slate-900 text-white relative -left-[100%] h-full w-[200%] transform smooth-transition flex justify-center items-center"
                 :class="isSignUp ? 'translate-x-[50%]' : 'translate-x-0'">

                <div class="w-[50%] flex flex-col justify-center items-center px-10 text-center transform smooth-transition h-full absolute left-0 top-0"
                     :class="isSignUp ? 'translate-x-0' : '-translate-x-[20%]'">
                    
                    <h1 class="font-bold text-3xl mb-4">Sudah Punya Akun?</h1>
                    <p class="text-sm text-blue-100 font-light mb-8 leading-relaxed">
                        Jika kamu sudah pernah mendaftar sebelumnya, silakan masuk di sini.
                    </p>
                    <button @click="isSignUp = false; window.history.pushState({}, '', '/login')" class="bg-transparent border border-white text-white text-xs font-bold uppercase py-3 px-10 rounded-xl tracking-wider hover:bg-white hover:text-blue-800 transition cursor-pointer z-50">
                        Masuk Disini
                    </button>
                </div>

                <div class="w-[50%] flex flex-col justify-center items-center px-10 text-center transform smooth-transition h-full absolute right-0 top-0"
                     :class="isSignUp ? 'translate-x-[20%]' : 'translate-x-0'">
                    
                    <h1 class="font-bold text-3xl mb-4">Halo, Sobat!</h1>
                    <p class="text-sm text-blue-100 font-light mb-8 leading-relaxed">
                        Belum punya akun? Daftar sekarang untuk mulai menggunakan aplikasi Anpundung.
                    </p>
                    <button @click="isSignUp = true; window.history.pushState({}, '', '/register')" class="bg-transparent border border-white text-white text-xs font-bold uppercase py-3 px-10 rounded-xl tracking-wider hover:bg-white hover:text-blue-800 transition cursor-pointer z-50">
                        Daftar Akun
                    </button>
                </div>

            </div>
        </div>

    </div>

</body>
</html>