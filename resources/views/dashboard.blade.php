<x-layouts.app title="Dashboard">
    @php $user = Illuminate\Support\Facades\Auth::user() @endphp

    <div class="max-w-7xl mx-auto">

        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">
                Selamat Datang, <span class="text-blue-600">{{ explode(' ', $user->name)[0] }}!</span>
            </h1>
            <p class="text-slate-500">
                Kelola laporan masuk dan pantau aktivitas sistem ANPUNDUNG.
            </p>
        </div>

        {{-- ======================= --}}
        {{--    ADMIN DASHBOARD      --}}
        {{-- ======================= --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div
                class="bg-gradient-to-br from-blue-600 to-slate-900 rounded-2xl p-6 text-white shadow-lg shadow-blue-200 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-blue-100 text-sm font-bold uppercase tracking-wider">Total Laporan</p>
                        <i class='bx bx-bar-chart text-2xl text-blue-200'></i>
                    </div>
                    <h2 class="text-4xl font-extrabold text-white">{{ $totalLaporan }}</h2>
                    <p class="text-xs text-blue-200 mt-2">Update Realtime</p>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center text-xl">
                            <i class='bx bx-time'></i>
                        </div>
                        <p class="text-slate-500 text-sm font-bold">Menunggu</p>
                    </div>
                    <span class="px-2 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-md">Action
                        Needed</span>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-800">{{ $laporanPending }}</h2>
            </div>

            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl">
                            <i class='bx bx-check-circle'></i>
                        </div>
                        <p class="text-slate-500 text-sm font-bold">Selesai</p>
                    </div>
                    <span
                        class="px-2 py-1 bg-emerald-100 text-emerald-600 text-xs font-bold rounded-md">Verified</span>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-800">{{ $laporanSelesai }}</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                        <i class='bx bx-grid-alt text-blue-600'></i> Menu Pengelola
                    </h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <a href="/laporan"
                            class="group bg-white p-6 rounded-2xl border border-slate-200 hover:border-blue-500 hover:ring-1 hover:ring-blue-500 transition cursor-pointer">
                            <div
                                class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                                <i class='bx bx-list-check'></i>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-1 group-hover:text-blue-600 transition">Kelola
                                Laporan</h4>
                            <p class="text-sm text-slate-500">Verifikasi, tolak, atau tindak lanjuti laporan warga.
                            </p>
                        </a>

                        <a href="/kategoris"
                            class="group bg-white p-6 rounded-2xl border border-slate-200 hover:border-blue-500 hover:ring-1 hover:ring-blue-500 transition cursor-pointer">
                            <div
                                class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                                <i class='bx bx-tag'></i>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-1 group-hover:text-purple-600 transition">
                                Kategori Laporan</h4>
                            <p class="text-sm text-slate-500">Tambah atau edit jenis pelanggaran pungli.</p>
                        </a>

                        <a href="{{ route('admin.news.index') }}"
                            class="group bg-white p-6 rounded-2xl border border-slate-200 hover:border-blue-500 hover:ring-1 hover:ring-blue-500 transition cursor-pointer">
                            <div
                                class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                                <i class='bx bxs-news'></i>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-1 group-hover:text-emerald-600 transition">
                                Kelola Berita</h4>
                            <p class="text-sm text-slate-500">Buat, edit, atau hapus berita dan artikel.</p>
                        </a>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-slate-800 text-lg mb-4">Profil Admin</h3>
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <div
                        class="w-20 h-20 mx-auto bg-slate-900 text-white rounded-full flex items-center justify-center text-3xl font-bold mb-4 shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h4 class="font-bold text-slate-800">{{ $user->name }}</h4>
                    <p class="text-xs text-slate-500 mb-4">{{ $user->email }}</p>
                    <div
                        class="inline-block px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold uppercase tracking-wide">
                        Administrator
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
