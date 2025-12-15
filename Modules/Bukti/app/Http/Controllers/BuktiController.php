<?php

namespace Modules\Bukti\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Bukti\Models\Bukti;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BuktiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bukti::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bukti::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_laporan' => 'required|exists:laporan,kode_laporan',
            'jenis'        => 'required|in:Gambar,Video',
            'file'         => 'required|file|mimes:jpg,jpeg,png,mp4|max:5120',
            'deskripsi'    => 'nullable|string',
        ]);

        $path = $request->file('file')->store('bukti', 'public');

        Bukti::create([
            'kode_laporan' => $request->kode_laporan,
            'jenis'        => $request->jenis,
            'path_file'    => $path,
            'deskripsi'    => $request->deskripsi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti berhasil diupload'
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('bukti::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('bukti::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bukti = Bukti::findOrFail($id);

        if ($bukti->path_file && Storage::disk('public')->exists($bukti->path_file)) {
            Storage::disk('public')->delete($bukti->path_file);
        }

        $bukti->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bukti berhasil dihapus',
        ]);
    }
}
