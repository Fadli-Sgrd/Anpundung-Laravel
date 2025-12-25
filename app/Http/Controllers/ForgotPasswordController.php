<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan Halaman Lupa Password
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Kirim Link Reset ke Email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak ditemukan di sistem.'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Generate token
        $token = Str::random(64);

        // Simpan token ke password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Generate reset URL
        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($user->email));

        // Kirim email
        try {
            Mail::send('emails.reset-password', [
                'user' => $user,
                'resetUrl' => $resetUrl,
                'token' => $token
            ], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Reset Password - Anpundung');
            });

            return back()->with(['status' => 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.']);
        } catch (\Exception $e) {
            \Log::error('Failed to send reset email: ' . $e->getMessage());
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Gagal mengirim email. Error: ' . $e->getMessage()]);
        }
    }

    // 3. Tampilkan Form Ganti Password Baru
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // 4. Proses Simpan Password Baru
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Ambil reset token record
        $resetRecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Token reset password tidak ditemukan atau telah expired.']);
        }

        // Verifikasi token
        if (!Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid.']);
        }

        // Cek apakah token sudah lebih dari 60 menit
        $tokenCreatedAt = strtotime($resetRecord->created_at);
        $now = time();
        $diff = ($now - $tokenCreatedAt) / 60; // dalam menit

        if ($diff > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset password telah expired. Silakan buat permintaan baru.']);
        }

        // Update password user
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token setelah berhasil
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}
