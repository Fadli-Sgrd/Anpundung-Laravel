<x-layouts.app title="Kontak Kami">
    <div class="max-w-6xl mx-auto px-4">

        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-4">Hubungi Tim Kami</h1>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto leading-relaxed">
                Punya pertanyaan, saran, atau kendala teknis? Kami siap mendengar dan membantu Anda.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 items-start">

            <div class="md:col-span-1 space-y-6">
                <div
                    class="bg-gradient-to-br from-blue-600 to-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-blue-200">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl -mr-10 -mt-10">
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                            <i class='bx bxs-contact'></i> Info Kontak
                        </h3>

                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center shrink-0 backdrop-blur-sm">
                                    <i class='bx bxs-map text-xl'></i>
                                </div>
                                <div>
                                    <p class="font-bold text-blue-100 text-sm mb-1">Sekretariat RW 14</p>
                                    <p class="text-xs opacity-80 leading-relaxed">Bandung, Jawa Barat<br>Indonesia</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center shrink-0 backdrop-blur-sm">
                                    <i class='bx bxs-envelope text-xl'></i>
                                </div>
                                <div>
                                    <p class="font-bold text-blue-100 text-sm mb-1">Email Resmi</p>
                                    <p class="text-xs opacity-80">help@anpundung.id</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                    <h4 class="font-bold text-blue-800 mb-2 flex items-center gap-2 text-sm">
                        <i class='bx bxs-info-circle'></i> Butuh Respon Cepat?
                    </h4>
                    <p class="text-xs text-blue-600/80 leading-relaxed">
                        Untuk pelaporan pungli yang mendesak, disarankan menggunakan menu @auth
                        <button type="button" class="font-bold underline hover:text-blue-800 js-open-lapor">
                            Buat Laporan
                        </button>
                        @else
                        <a href="/register" class="font-bold underline hover:text-blue-800">
                            Buat Laporan
                        </a>
                        @endauth agar langsung masuk ke sistem prioritas kami.
                    </p>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white rounded-[2rem] p-8 md:p-10 shadow-sm border border-slate-100">
                    <h3 class="text-2xl font-bold text-slate-800 mb-6">Kirim Pesan</h3>

                    @if (session('success'))
                    <div
                        class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
                        <i class='bx bxs-check-circle text-xl mt-0.5'></i>
                        <div>
                            <p class="font-bold text-sm">Berhasil!</p>
                            <p class="text-xs">{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="/kontak" class="space-y-5">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label for="nama" class="block text-sm font-bold text-slate-700 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm text-slate-700 placeholder-slate-400 font-medium"
                                    placeholder="Nama Anda">
                                @error('nama') <div class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Alamat
                                    Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm text-slate-700 placeholder-slate-400 font-medium"
                                    placeholder="email@contoh.com">
                                @error('email') <div class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-bold text-slate-700 mb-2">Subjek
                                Pesan</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm text-slate-700 placeholder-slate-400 font-medium"
                                placeholder="Contoh: Kendala Login / Saran Fitur">
                            @error('subject') <div class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-bold text-slate-700 mb-2">Isi Pesan</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm text-slate-700 placeholder-slate-400 font-medium font-sans"
                                placeholder="Tuliskan pesan Anda secara detail di sini...">{{ old('message') }}</textarea>
                            @error('message') <div class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 transition transform active:scale-95 flex items-center justify-center gap-2">
                                <i class='bx bx-paper-plane text-xl'></i> Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-laporan-modal :kategori="$kategori" />

@push('scripts')
  <script src="{{ asset('js/pages/kontak.js') }}"></script>
@endpush

</x-layouts.app>
