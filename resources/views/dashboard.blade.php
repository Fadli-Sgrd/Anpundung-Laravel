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
            <x-stat-card 
                variant="solid" 
                title="Total Laporan"
                value="{{ $totalLaporan }}"
                icon="bx bx-bar-chart"
                color="blue"
                subtext="Update Realtime"
            />

            <x-stat-card 
                variant="outline" 
                title="Menunggu"
                value="{{ $laporanPending }}"
                icon="bx bx-time"
                color="orange"
                badge="Action Needed"
            />

            <x-stat-card 
                variant="outline" 
                title="Selesai"
                value="{{ $laporanSelesai }}"
                icon="bx bx-check-circle"
                color="emerald"
                badge="Verified"
            />
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
                        <x-menu-card 
                            href="/laporan"
                            icon="bx bx-list-check"
                            title="Kelola Laporan"
                            description="Mengubah Status Laporan, Pending, Selesai, Ditolak."
                            color="blue"
                        />

                        <x-menu-card 
                            href="/kategoris"
                            icon="bx bx-tag"
                            title="Kategori Laporan"
                            description="Tambah atau edit jenis pelanggaran pungli."
                            color="purple"
                        />

                        <x-menu-card 
                            href="{{ route('admin.news.index') }}"
                            icon="bx bxs-news"
                            title="Kelola Berita"
                            description="Membuat, mengedit, atau menghapus berita."
                            color="emerald"
                        />

                        <x-menu-card 
                            href="{{ route('admin.pesan.index') }}"
                            icon="bx bxs-envelope"
                            title="Pesan Masuk"
                            description="Lihat pesan dari form kontak pengunjung."
                            color="pink"
                            badge="{{ $totalPesan }}"
                        />
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
