<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Input tidak valid',
                'errors'  => $validator->errors()
            ], 422);
        }


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $tokenBaru = bin2hex(random_bytes(40));
            
            $user->api_token = $tokenBaru;
            $user->save();
             
            return response()->json([
                'status'  => true,
                'message' => 'Login Berhasil',
                'data'    => [
                    'id'    => $user->id,
                    'nama'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->role,
                    'token' => $tokenBaru,
                ]
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Email atau Password salah',
        ], 401);
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user) {
            // Hapus token di database (Set jadi NULL)
            $user->api_token = null;
            $user->save();

            return response()->json([
                'status'  => true,
                'message' => 'Logout Berhasil',
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Gagal Logout',
        ], 401);
    }
}