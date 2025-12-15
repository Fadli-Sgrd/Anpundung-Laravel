<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiAuth
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'Token tidak ditemukan'
            ], 401);
        }

        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Token tidak valid'
            ], 401);
        }

        // SET USER KE AUTH SYSTEM (TANPA auth() HELPER)
        Auth::setUser($user);

        return $next($request);
    }
}
