<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kategori\Models\Kategori; 

class KategoriController extends Controller
{
    public function index()
    {
        // Ambil semua data kategori dari database
        $data = Kategori::all();

        return response()->json([
            'status'  => true,
            'message' => 'List Data Kategori',
            'data'    => $data
        ], 200);
    }
}