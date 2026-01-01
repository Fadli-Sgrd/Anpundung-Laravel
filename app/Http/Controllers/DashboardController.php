<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\Laporan\Models\Laporan;
use Modules\Kontak\Models\Kontak;

class DashboardController extends Controller
{
    /**
     * Show dashboard berdasarkan role user
     */
    public function index()
    {
        // 1. Logic Hitung Data (Efficient grouping)
        $stats = Laporan::selectRaw('status_tindakan, count(*) as total')
            ->groupBy('status_tindakan')
            ->pluck('total', 'status_tindakan');

        $totalLaporan   = $stats->sum();
        $laporanPending = $stats->get('Pending', 0);
        $laporanSelesai = $stats->get('Selesai', 0);

        // 2. Data untuk Grafik - Tren Laporan 7 Hari Terakhir
        $trendLaporan = $this->getTrendLaporan();

        // 3. Data untuk Grafik - Status Laporan (Pie Chart)
        $statusData = $this->getStatusData();

        // 4. Total Pesan Kontak Masuk
        $totalPesan = Kontak::count();

        // 5. Kirim Data ke View
        return view('dashboard', compact(
            'totalLaporan',
            'laporanPending',
            'laporanSelesai',
            'trendLaporan',
            'statusData',
            'totalPesan'
        ));
    }

    /**
     * Get tren laporan untuk 7 hari terakhir - Optimized to single query
     */
    private function getTrendLaporan()
    {
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        
        $laporanCounts = Laporan::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, count(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $dates = [];
        $counts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = Carbon::parse($date)->format('d M');
            $counts[] = $laporanCounts->get($date, 0);
        }

        return [
            'labels' => $dates,
            'data' => $counts
        ];
    }

    /**
     * Get data status laporan
     */
    private function getStatusData()
    {
        $statuses = Laporan::select('status_tindakan', DB::raw('count(*) as total'))
            ->groupBy('status_tindakan')
            ->pluck('total', 'status_tindakan')
            ->toArray();

        $labels = array_keys($statuses);
        $data = array_values($statuses);

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
