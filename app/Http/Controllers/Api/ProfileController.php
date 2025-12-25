<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // 1. GET: Lihat Data Diri Sendiri
    public function show()
    {
        $user = Auth::user(); // Ambil data user dari token

        return response()->json([
            'status'  => true,
            'message' => 'Data Profile User',
            'data'    => $user
        ], 200);
    }

    // 2. POST: Update Profile (Ganti Nama & Password)
    public function update(Request $request)
    {
        $user = Auth::user(); // User yang sedang login

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'password' => 'nullable|min:6', // Password boleh kosong kalau gak mau diganti
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update Nama
        $user->name = $request->name;

        // Update Password (Hanya jika diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Simpan ke database

        return response()->json([
            'status'  => true,
            'message' => 'Profile Berhasil Diupdate',
            'data'    => $user
        ], 200);
    }
}