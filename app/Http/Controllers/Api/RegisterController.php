<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email', // Email gak boleh kembar
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Buat User Baru
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'user', // Default role untuk pendaftar umum
            'api_token' => bin2hex(random_bytes(40)) // Langsung kasih token
        ]);

        // 3. Kirim Respon Sukses + Token
        return response()->json([
            'status'  => true,
            'message' => 'Registrasi Berhasil',
            'data'    => [
                'user'  => $user,
                'token' => $user->api_token // Kirim token biar HP bisa langsung simpan
            ]
        ], 201);
    }
}