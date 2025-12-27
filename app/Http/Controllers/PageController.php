<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Laporan\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Modules\Kategori\Models\Kategori;
use Inertia\Inertia;


class PageController extends Controller
{
    /**
     * Home page - buat laporan & pencegahan pungli
     */
    public function home()
    {
         $kategori = Kategori::all();
        return Inertia::render('Home', compact('kategori'));
    }

    /**
     * Edukasi - info pencegahan pungli
     */
    public function edukasi()
    {
     $kategori = Kategori::all();
        return Inertia::render('Edukasi', compact('kategori'));
    }

    /**
     * Berita - public laporan dari semua user
     */
    public function riwayat()
    {
        $laporan = Laporan::with(['user', 'kategori', 'bukti'])
            ->latest()
            ->get();

        return view('pages.riwayat', compact('laporan'));
    }

    /**
     * Profile - user profile page
     */
    public function profile()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}