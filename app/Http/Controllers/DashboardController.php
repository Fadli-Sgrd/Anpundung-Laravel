<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\Laporan\Models\Laporan;

class DashboardController extends Controller
{
    /**
     * Show dashboard berdasarkan role user
     */
    public function index()
    {
        // 1. Logic Hitung Data (Realtime dari Database)
        $totalLaporan   = Laporan::count();
        $laporanPending = Laporan::where('status_tindakan', 'Pending')->count();
        $laporanSelesai = Laporan::where('status_tindakan', 'Selesai')->count();

        // 2. Data untuk Grafik - Tren Laporan 7 Hari Terakhir
        $trendLaporan = $this->getTrendLaporan();

        // 3. Data untuk Grafik - Status Laporan (Pie Chart)
        $statusData = $this->getStatusData();

        // 4. Kirim Data ke View (Agar bisa dipanggil pakai {{ $nama_variabel }})
        return view('dashboard', compact(
            'totalLaporan',
            'laporanPending',
            'laporanSelesai',
            'trendLaporan',
            'statusData'
        ));
    }

    /**
     * Get tren laporan untuk 7 hari terakhir
     */
    private function getTrendLaporan()
    {
        $dates = [];
        $counts = [];

        // Generate 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = Carbon::parse($date)->format('d M');

            $count = Laporan::whereDate('created_at', $date)->count();
            $counts[] = $count;
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
