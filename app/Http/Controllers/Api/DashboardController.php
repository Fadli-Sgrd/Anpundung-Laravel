<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Laporan\Models\Laporan; 

class DashboardController extends Controller
{
    public function index()
    {
        $stats = Laporan::selectRaw('status_tindakan, count(*) as total')
            ->groupBy('status_tindakan')
            ->pluck('total', 'status_tindakan');

        return response()->json([
            'status' => true,
            'message' => 'Data Statistik Dashboard',
            'data' => [
                'total_laporan' => $stats->sum(),
                'status_pending' => $stats->get('Pending', 0),
                'status_proses' => $stats->get('Proses', 0),
                'status_selesai' => $stats->get('Selesai', 0),
            ]
        ], 200);
    }
}