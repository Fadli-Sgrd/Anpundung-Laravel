<x-layouts.app title="Beranda">

    <style>
        /* Kondisi awal elemen sebelum muncul */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s ease-out;
        }

        /* Kondisi setelah elemen terlihat di layar (di-trigger oleh JS di bawah) */
        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Delay bertingkat untuk elemen yang berjejer (biar munculnya satu-satu) */
        .delay-100 {
            transition-delay: 0.1s;
        }

        .delay-200 {
            transition-delay: 0.2s;
        }

        .delay-300 {
            transition-delay: 0.3s;
        }
    </style>

    <div style="width: 100vw; margin-left: calc(50% - 50vw); margin-top: -7rem;" class="relative overflow-hidden mb-16">

        <div class="relative w-full h-screen overflow-hidden" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">

            <div class="absolute inset-0 bg-fixed bg-center bg-cover z-0 transition-transform duration-[3000ms] ease-out transform"
                :class="loaded ? 'scale-100' : 'scale-110'"
                style="background-image: url('https://images.unsplash.com/photo-1611638281871-1063d3e76e1f?q=80&w=1433&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
            </div>

            <div
                class="absolute inset-0 bg-gradient-to-t
                from-slate-900/60
                via-slate-900/30
                to-blue-900/20
                z-10">
            </div>



            <div class="relative z-20 h-full flex flex-col items-center justify-center text-center px-4 pt-20">

                <div class="transition-all duration-1000 ease-out transform translate-y-10 opacity-0"
                    :class="loaded ? '!translate-y-0 !opacity-100' : ''">
                    <span
                        class="inline-block py-2 px-6 rounded-full bg-white/10 border border-white/20 text-blue-100 text-xs font-bold tracking-[0.3em] uppercase mb-8 backdrop-blur-md shadow-2xl">
                        Official Platform Annpundung
                    </span>
                </div>

                <h1 class="text-5xl md:text-8xl font-extrabold text-white mb-6 leading-tight drop-shadow-2xl transition-all duration-1000 delay-300 ease-out transform translate-y-10 opacity-0"
                    :class="loaded ? '!translate-y-0 !opacity-100' : ''">
                    Bandung <br>
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-400 to-blue-200">Bebas
                        Pungli</span>
                </h1>

                <p class="text-lg md:text-2xl text-slate-200 mb-12 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md transition-all duration-1000 delay-500 ease-out transform translate-y-10 opacity-0"
                    :class="loaded ? '!translate-y-0 !opacity-100' : ''">
                    Bersama ANPUNDUNG, wujudkan layanan publik yang bersih, transparan, dan bermartabat.
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-5 transition-all duration-1000 delay-700 ease-out transform translate-y-10 opacity-0"
                    :class="loaded ? '!translate-y-0 !opacity-100' : ''">
                    @auth
                        <button type="button" id="btn-open-lapor"
                            class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-full shadow-[0_0_30px_rgba(37,99,235,0.6)] transition-all hover:scale-105 flex items-center gap-3">
                            <i class='bx bxs-megaphone text-xl'></i> Laporkan Sekarang
                        </button>
                    @else
                        <a href="/login"
                            class="px-10 py-4 bg-white text-slate-900 font-bold rounded-full shadow-2xl transition-all hover:scale-105 hover:bg-slate-100 flex items-center gap-3">
                            <i class='bx bxs-user-circle text-xl'></i> Masuk / Daftar
                        </a>
                    @endauth

                    <a href="#tentang"
                        class="px-10 py-4 bg-white/5 hover:bg-white/10 border border-white/30 text-white font-bold rounded-full backdrop-blur-md transition-all hover:scale-105 flex items-center gap-2">
                        <i class='bx bx-info-circle text-xl'></i> Pelajari
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 mb-32 relative z-30">
        <div class="grid md:grid-cols-3 gap-8">
            <div
                class="reveal-on-scroll bg-white p-8 rounded-[2rem] shadow-xl border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-center group">
                <div
                    class="w-20 h-20 mx-auto bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-4xl mb-6 group-hover:scale-110 transition">
                    <i class='bx bxs-shield-check'></i>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-2">100%</h3>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Identitas Aman</p>
            </div>

            <div
                class="reveal-on-scroll delay-100 bg-white p-8 rounded-[2rem] shadow-xl border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-center group">
                <div
                    class="w-20 h-20 mx-auto bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-4xl mb-6 group-hover:scale-110 transition">
                    <i class='bx bxs-time-five'></i>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-2">24/7</h3>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Siap Melayani</p>
            </div>

            <div
                class="reveal-on-scroll delay-200 bg-white p-8 rounded-[2rem] shadow-xl border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-center group">
                <div
                    class="w-20 h-20 mx-auto bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-4xl mb-6 group-hover:scale-110 transition">
                    <i class='bx bxs-data'></i>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-2">Realtime</h3>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Pantau Status</p>
            </div>
        </div>
    </div>

    <section id="tentang" class="py-12 max-w-6xl mx-auto px-4 mb-24">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <div class="lg:w-1/2 reveal-on-scroll">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold uppercase tracking-widest mb-6">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Misi Kami
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight">
                    Transparansi Adalah <br> <span class="text-blue-600">Kunci Kepercayaan.</span>
                </h2>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed text-justify">
                    Anpundung hadir untuk menjembatani warga Bandung dengan pengelola lingkungan dalam memberantas
                    praktik pungutan liar. Sistem ini dirancang untuk memberikan rasa aman bagi pelapor dan memastikan
                    setiap aduan ditindaklanjuti.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="flex items-center gap-3">
                        <i class='bx bxs-check-circle text-green-500 text-xl'></i>
                        <span class="font-bold text-slate-700">Enkripsi Data</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class='bx bxs-check-circle text-green-500 text-xl'></i>
                        <span class="font-bold text-slate-700">Respon Cepat</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class='bx bxs-check-circle text-green-500 text-xl'></i>
                        <span class="font-bold text-slate-700">Anonimitas</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class='bx bxs-check-circle text-green-500 text-xl'></i>
                        <span class="font-bold text-slate-700">Gratis</span>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2 relative reveal-on-scroll delay-200">
                <div class="absolute inset-0 bg-blue-600 rounded-[2.5rem] rotate-6 opacity-10 transform scale-95"></div>
                <img src="https://images.unsplash.com/photo-1590476355683-96c1859f4658?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    class="relative rounded-[2.5rem] shadow-2xl w-full object-cover h-[500px] border-4 border-white transition-transform hover:scale-[1.02] duration-500">
            </div>
        </div>
    </section>



    <div style="width: 100vw; margin-left: calc(50% - 50vw);" class="py-24 bg-slate-50 px-4 mb-20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 reveal-on-scroll">
                <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-4">Lapor Pungli Semudah 1-2-3</h2>
                <p class="text-slate-500 text-lg">Jangan takut melapor. Sistem kami melindungi privasi Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="reveal-on-scroll bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 p-6 text-9xl font-black text-slate-100 -mr-6 -mt-6 group-hover:scale-110 transition">
                        1</div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:rotate-12 transition">
                            <i class='bx bx-edit'></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-4">Buat Laporan</h3>
                        <p class="text-slate-500 leading-relaxed">
                            Isi formulir kejadian dengan lengkap. Lampirkan foto atau video sebagai bukti pendukung yang
                            kuat.
                        </p>
                    </div>
                </div>
                <div
                    class="reveal-on-scroll delay-100 bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 p-6 text-9xl font-black text-slate-100 -mr-6 -mt-6 group-hover:scale-110 transition">
                        2</div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:rotate-12 transition">
                            <i class='bx bx-search-alt'></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-4">Verifikasi</h3>
                        <p class="text-slate-500 leading-relaxed">
                            Admin kami akan memvalidasi laporan Anda. Anda dapat memantau statusnya di Dashboard secara
                            realtime.
                        </p>
                    </div>
                </div>
                <div
                    class="reveal-on-scroll delay-200 bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 p-6 text-9xl font-black text-slate-100 -mr-6 -mt-6 group-hover:scale-110 transition">
                        3</div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:rotate-12 transition">
                            <i class='bx bx-check-double'></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-4">Tindak Lanjut</h3>
                        <p class="text-slate-500 leading-relaxed">
                            Laporan valid akan ditindaklanjuti oleh pihak berwenang. Lingkungan kembali aman dan nyaman.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 mb-24 reveal-on-scroll">
        <div
            class="relative rounded-[3rem] bg-slate-900/90 backdrop-blur-md overflow-hidden py-24 text-center px-6 shadow-2xl shadow-blue-900/30 group border border-white/10">
            <div
                class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-blue-600/30 rounded-full blur-[100px] group-hover:bg-blue-600/40 transition duration-1000 animate-pulse">
            </div>
            <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-purple-600/30 rounded-full blur-[100px] group-hover:bg-purple-600/40 transition duration-1000 animate-pulse"
                style="animation-delay: 1s"></div>

            <div class="relative z-10 max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-6xl font-extrabold text-white mb-8 leading-tight">
                    Jangan Biarkan Pungli <br> Merusak Harimu.
                </h2>

                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    @auth
                        <button type="button" id="btn-open-lapor-2"
                            class="px-10 py-5 bg-white/10 backdrop-blur-md border border-white/30 text-white font-bold rounded-full shadow-lg hover:bg-white hover:text-blue-900 hover:scale-105 transition transform flex items-center justify-center gap-2">
                            <i class='bx bx-plus-circle'></i> Buat Laporan
                        </button>
                    @else
                        <a href="/register"
                            class="px-10 py-5 bg-white/10 backdrop-blur-md border border-white/30 text-white font-bold rounded-full shadow-lg hover:bg-white hover:text-blue-900 hover:scale-105 transition transform flex items-center justify-center gap-2">
                            <i class='bx bx-user-plus'></i> Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <x-laporan-modal :kategori="$kategori" />
@push('scripts')
<script src="{{ asset('js/pages/home.js') }}"></script>
@endpush



    <script>
document.addEventListener('DOMContentLoaded', function () {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-on-scroll')
        .forEach(el => observer.observe(el));
});
</script>


</x-layouts.app>
