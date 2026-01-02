<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// Panggil Model Kontak yang ada di Modules
use Modules\Kontak\Models\Kontak;

class KontakController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Simpan ke Database
        $kontak = Kontak::create([
            'nama'    => $request->nama,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status'  => 'unread' // Default status
        ]);

        // 3. Beri Respon Sukses
        if ($kontak) {
            return response()->json([
                'status'  => true,
                'message' => 'Pesan berhasil dikirim',
                'data'    => $kontak
            ], 201);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Gagal mengirim pesan',
        ], 500);
    }
}