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
                    <span class="px-2 py-1 bg-emerald-100 text-emerald-600 text-xs font-bold rounded-md">Verified</span>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-800">{{ $laporanSelesai }}</h2>
            </div>
        </div>

        {{-- ======================= --}}
        {{--     GRAFIK DASHBOARD    --}}
        {{-- ======================= --}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Grafik Tren Laporan -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        <i class='bx bx-line-chart text-blue-600'></i> Tren Laporan 7 Hari Terakhir
                    </h3>
                </div>
                <canvas id="trendChart" style="max-height: 300px;"></canvas>
            </div>

            <!-- Grafik Status Laporan -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        <i class='bx bx-pie-chart-alt text-purple-600'></i> Status Laporan
                    </h3>
                </div>
                <canvas id="statusChart" style="max-height: 300px;"></canvas>
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
                            <p class="text-sm text-slate-500">Mengubah Status Laporan, Pending, Selesai, Ditolak.
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
                            <p class="text-sm text-slate-500">Membuat, mengedit, atau menghapus berita.</p>
                        </a>

                        <a href="{{ route('admin.pesan.index') }}"
                            class="group bg-white p-6 rounded-2xl border border-slate-200 hover:border-blue-500 hover:ring-1 hover:ring-blue-500 transition cursor-pointer">
                            <div
                                class="w-12 h-12 bg-pink-50 text-pink-600 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                                <i class='bx bxs-envelope'></i>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-1 group-hover:text-pink-600 transition">
                                Pesan Masuk <span
                                    class="ml-1 px-2 py-0.5 bg-pink-100 text-pink-600 text-xs rounded-full">{{ $totalPesan }}</span>
                            </h4>
                            <p class="text-sm text-slate-500">Lihat pesan dari form kontak pengunjung.</p>
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

    {{-- ======================= --}}
    {{--     CHART.JS LIBRARY    --}}
    {{-- ======================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

    <script>
        // Data dari Laravel
        const trendData = @json($trendLaporan);
        const statusData = @json($statusData);

        // ========== GRAFIK TREN LAPORAN ==========
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendData.labels,
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: trendData.data,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#1e40af',
                    pointHoverBorderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#475569',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#94a3b8'
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.5)',
                        }
                    },
                    x: {
                        ticks: {
                            color: '#94a3b8'
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.5)',
                        }
                    }
                }
            }
        });

        // ========== GRAFIK STATUS LAPORAN ==========
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const colors = ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'];

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusData.labels,
                datasets: [{
                    data: statusData.data,
                    backgroundColor: colors.slice(0, statusData.labels.length),
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#475569',
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            padding: 15
                        }
                    }
                }
            }
        });
    </script>
</x-layouts.app>
