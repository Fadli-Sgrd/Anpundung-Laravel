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
        $kategori = Kategori::all();
        return Inertia::render('Kontak', compact('kategori'));
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
}
