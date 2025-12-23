<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // 2. Kirim Data ke View (Agar bisa dipanggil pakai {{ $nama_variabel }})
        return view('dashboard', compact(
            'totalLaporan', 
            'laporanPending', 
            'laporanSelesai'
        ));
    }
}