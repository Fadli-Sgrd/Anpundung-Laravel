<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Anpundung') }} - Stop Bullying</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        .scroll-hidden::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="antialiased text-slate-800 bg-white" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <nav class="fixed w-full z-50 top-0 transition-all duration-300"
         :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm py-4' : 'bg-transparent py-6'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                    <i class='bx bxs-shield-plus text-2xl'></i>
                </div>
                <span class="font-bold text-xl tracking-tight" :class="scrolled ? 'text-slate-800' : 'text-slate-800'">Anpundung.</span>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="#" class="text-sm font-medium hover:text-blue-600 transition">Beranda</a>
                <a href="#berita" class="text-sm font-medium hover:text-blue-600 transition">Berita</a>
                <a href="#kontak" class="text-sm font-medium hover:text-blue-600 transition">Kontak</a>
            </div>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition transform hover:-translate-y-0.5">Daftar</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <header class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] bg-indigo-50 rounded-full blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col-reverse lg:flex-row items-center gap-12 lg:gap-20">
            <div class="lg:w-1/2 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold uppercase tracking-wider mb-6">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Platform Anti Perundungan
                </div>
                <h1 class="text-4xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                    Ciptakan Lingkungan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Aman & Nyaman</span>
                </h1>
                <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                    Jangan diam saat melihat perundungan. Anpundung hadir sebagai wadah aman untuk melapor, bercerita, dan mencari solusi bersama.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition text-center">
                        Laporkan Sekarang
                    </a>
                    <a href="#pelajari" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 border border-slate-200 font-bold rounded-xl hover:bg-slate-50 transition flex items-center justify-center gap-2">
                        <i class='bx bx-play-circle text-xl'></i> Pelajari Cara Kerja
                    </a>
                </div>
                
                <div class="mt-10 flex items-center justify-center lg:justify-start gap-8 pt-8 border-t border-slate-100">
                    <div>
                        <p class="text-2xl font-bold text-slate-900">500+</p>
                        <p class="text-xs text-slate-500">Siswa Terbantu</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">24/7</p>
                        <p class="text-xs text-slate-500">Layanan Aduan</p>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2 relative">
                <div class="relative z-10 bg-gradient-to-br from-blue-600 to-slate-900 rounded-[3rem] p-2 shadow-2xl rotate-3 hover:rotate-0 transition duration-500">
                    <img src="https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Friendship" class="rounded-[2.5rem] object-cover w-full h-[400px] opacity-90">
                    
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <i class='bx bxs-check-shield text-2xl'></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">100% Rahasia</p>
                            <p class="text-xs text-slate-500">Identitasmu aman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="berita" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900">Berita & Edukasi</h2>
                <p class="text-slate-500 mt-2">Artikel terbaru seputar pencegahan perundungan</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition group">
                    <div class="h-48 bg-blue-200 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-blue-600 uppercase">Tips</span>
                        <h3 class="text-lg font-bold text-slate-900 mt-2 mb-2 group-hover:text-blue-600 transition">Cara Menghadapi Cyberbullying</h3>
                        <p class="text-sm text-slate-500">Jangan membalas, simpan bukti, dan laporkan. Simak langkah lengkapnya.</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition group">
                    <div class="h-48 bg-indigo-200 overflow-hidden">
                         <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-indigo-600 uppercase">Edukasi</span>
                        <h3 class="text-lg font-bold text-slate-900 mt-2 mb-2 group-hover:text-indigo-600 transition">Kenali Tanda Teman Dibully</h3>
                        <p class="text-sm text-slate-500">Perubahan perilaku bisa jadi tanda. Mari lebih peka terhadap sekitar.</p>
                    </div>
                </div>
                 <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition group">
                    <div class="h-48 bg-purple-200 overflow-hidden">
                         <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-purple-600 uppercase">Hukum</span>
                        <h3 class="text-lg font-bold text-slate-900 mt-2 mb-2 group-hover:text-purple-600 transition">Pasal Hukum Perundungan</h3>
                        <p class="text-sm text-slate-500">Mengetahui dasar hukum untuk perlindungan korban di Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-blue-600 to-slate-900 rounded-[3rem] p-10 md:p-16 text-center text-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                
                <h2 class="text-3xl md:text-4xl font-bold mb-4 relative z-10">Butuh Bantuan Langsung?</h2>
                <p class="text-blue-100 mb-8 max-w-2xl mx-auto relative z-10">
                    Tim kami siap membantu 24/7. Kerahasiaan identitas pelapor adalah prioritas utama kami.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                    <a href="mailto:help@anpundung.id" class="px-8 py-4 bg-white text-blue-900 font-bold rounded-xl hover:bg-blue-50 transition flex items-center justify-center gap-2">
                        <i class='bx bxs-envelope text-xl'></i> Kirim Email
                    </a>
                    <a href="#" class="px-8 py-4 bg-transparent border border-white text-white font-bold rounded-xl hover:bg-white/10 transition flex items-center justify-center gap-2">
                        <i class='bx bxl-whatsapp text-xl'></i> Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-4 gap-8">
            <div class="col-span-2">
                <div class="flex items-center gap-2 text-white mb-4">
                    <i class='bx bxs-shield-plus text-2xl text-blue-500'></i>
                    <span class="font-bold text-xl">Anpundung.</span>
                </div>
                <p class="text-sm text-slate-400 max-w-xs">
                    Membangun sekolah dan lingkungan yang aman, nyaman, dan bebas dari perundungan untuk masa depan yang lebih baik.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Tautan</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Sosial Media</h4>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition text-white"><i class='bx bxl-instagram'></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition text-white"><i class='bx bxl-twitter'></i></a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 mt-12 pt-8 border-t border-slate-800 text-center text-xs text-slate-500">
            &copy; 2025 Anpundung Project. All rights reserved.
        </div>
    </footer>

</body>
</html>