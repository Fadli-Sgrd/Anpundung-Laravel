<?php

namespace Modules\Kategori\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kategori\Models\Kategori; 
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Tampilkan daftar kategori
     */
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('kategori::index', compact('kategoris'));
    }

    /**
     * Tampilkan form tambah kategori
     */
    public function create()
    {
        return view('kategori::create');
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_laporan,nama_kategori', // Cek unique ke tabel 'kategori_laporan'
            'deskripsi'     => 'nullable|string', // Deskripsi boleh kosong
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect('/kategoris')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori::edit', compact('kategori'));
    }

    /**
     * Update kategori
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            // Ignore ID saat cek unique agar tidak error saat update diri sendiri
            'nama_kategori' => 'required|string|max:255|unique:kategori_laporan,nama_kategori,' . $id,
            'deskripsi'     => 'nullable|string',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect('/kategoris')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect('/kategoris')->with('success', 'Kategori berhasil dihapus!');
    }
}