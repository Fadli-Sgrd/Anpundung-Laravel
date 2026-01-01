<?php

namespace Modules\Kontak\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kontak\Models\Kontak;
use Modules\Kategori\Models\Kategori; // ini yang kurang
use Inertia\Inertia;

class KontakController extends Controller
{
    public function index()
    {
        $kategori = Kategori::select('id', 'nama_kategori')->get();
        return Inertia::render('Kontak/Index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);
        
        Kontak::create($validated);

        return redirect()->back()->with('success', 'Pesan kontak Anda berhasil dikirim. Kami akan segera merespon.');
    }

    public function adminIndex()
    {
        // Mengambil semua data pesan, diurutkan dari yang terbaru (LIFO)
        $feedback = Kontak::latest()->get();
        
        // Mengembalikan view Blade admin
        return view('kontak::admin-index', compact('feedback'));
    }

    /**
     * Hapus pesan kontak
     */
    public function destroy($id)
    {
        $pesan = Kontak::findOrFail($id);
        $pesan->delete();

        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }
}