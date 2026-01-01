<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Laporan\Models\Laporan;

class LaporanController extends Controller
{
    /**
     * GET: Menampilkan History Laporan User (Read)
     */
    public function index()
    {
        $userId = Auth::id();

        $data = Laporan::with(['kategori', 'bukti'])
                       ->where('user_id', $userId)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return response()->json([
            'status'  => true,
            'message' => 'List Riwayat Laporan',
            'data'    => $data
        ], 200);
    }

    /**
     * POST: Mengirim Laporan Baru (Create)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'       => 'required|string|max:255',
            'tanggal'     => 'required|date',
            'alamat'      => 'required|string',
            'deskripsi'   => 'required|string',
            'id_kategori' => 'required|numeric', 
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Input tidak valid',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            
            $laporan = Laporan::create([
                'judul'           => $request->judul,
                'tanggal'         => $request->tanggal,
                'alamat'          => $request->alamat,
                'deskripsi'       => $request->deskripsi,
                'id_kategori'     => $request->id_kategori,
                'user_id'         => Auth::id(),
                'status_tindakan' => 'Pending', 
            ]);

            
            return response()->json([
                'status'  => true,
                'message' => 'Laporan Berhasil Terkirim',
                'data'    => $laporan
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan data (Server Error)',
                'error'   => $e->getMessage() // Matikan ini saat presentasi agar error bersih
            ], 500);
        }
    }
    
    // 3. GET: Detail Laporan berdasarkan Kode Laporan
    public function show($id)
    {

        $laporan = Laporan::with(['kategori', 'bukti'])
                          ->where('user_id', Auth::id())
                          ->where('kode_laporan', $id) 
                          ->first();

        if ($laporan) {
            return response()->json([
                'status'  => true,
                'message' => 'Detail Data Laporan',
                'data'    => $laporan
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())
                          ->where('kode_laporan', $id)
                          ->first();

        if ($laporan) {
            $laporan->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Laporan Berhasil Dihapus',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus (Data tidak ditemukan)',
            ], 404);
        }
    }

    // 5. UPDATE: Edit Laporan (Hanya kalau status masih Pending)
    public function update(Request $request, $id)
    {
        $laporan = Laporan::where('user_id', Auth::id())
                          ->where('kode_laporan', $id)
                          ->first();

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        if ($laporan->status_tindakan != 'Pending') {
            return response()->json(['message' => 'Laporan sudah diproses, tidak bisa diedit'], 403);
        }

        $validator = Validator::make($request->all(), [
            'judul'       => 'required|string',
            'deskripsi'   => 'required|string',
            'alamat'      => 'required|string',
            // 'tanggal'     => 'required|date',
            // 'id_kategori' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $laporan->update([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'alamat'    => $request->alamat,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Laporan Berhasil Diupdate',
            'data'    => $laporan
        ], 200);
    }
}