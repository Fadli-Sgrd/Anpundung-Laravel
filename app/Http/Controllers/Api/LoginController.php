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
            $user = Auth::user();

            return response()->json([
                'status'  => true,
                'message' => 'Login Berhasil',
                'data'    => [
                    'id'    => $user->id,
                    'nama'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->role,
                    'token' => $user->api_token,
                ]
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Email atau Password salah',
        ], 401);
    }
}