<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Laporan\Models\Laporan; 

class DashboardController extends Controller
{
    public function index()
    {
        $totalLaporan = Laporan::count();
        $pending      = Laporan::where('status_tindakan', 'Pending')->count();
        $proses       = Laporan::where('status_tindakan', 'Proses')->count();
        $selesai      = Laporan::where('status_tindakan', 'Selesai')->count();

        return response()->json([
            'status' => true,
            'message' => 'Data Statistik Dashboard',
            'data' => [
                'total_laporan' => $totalLaporan,
                'status_pending' => $pending,
                'status_proses' => $proses,
                'status_selesai' => $selesai,
            ]
        ], 200);
    }
}