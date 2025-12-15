<?php

namespace Modules\Kategori\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kategori\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kategori::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string|max:1000',
        ]);

        $kategori = Kategori::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $kategori,
            ], 201);
        }

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dibuat');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori::show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori::edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string|max:1000',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $kategori,
            ]);
        }

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->laporan()->exists()) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa hapus kategori yang memiliki laporan',
                ], 422);
            }
            return redirect()->back()
                ->withErrors('Tidak bisa hapus kategori yang memiliki laporan');
        }

        $kategori->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus',
            ]);
        }

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
