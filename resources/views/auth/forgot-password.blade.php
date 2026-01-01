<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Anpundung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 border border-slate-100 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-cyan-400"></div>

        <div class="mb-6 inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 text-blue-600 mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 19l-1 1-1-1-2-2-2-2 1-1m8.743-4.743A5.961 5.961 0 0115 17a6 6 0 01-6-6 3 3 0 01.75-2.051M3 3l18 18"></path></svg>
        </div>

        <h2 class="text-2xl font-bold text-slate-800 mb-2">Lupa Kata Sandi?</h2>
        <p class="text-slate-500 text-sm mb-8 leading-relaxed">
            Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mereset kata sandi Anda.
        </p>

        @if (session('status'))
            <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm mb-6 text-left flex gap-3 items-start">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="text-left mb-6">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Email Address</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none text-sm transition" placeholder="nama@email.com" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                Kirim Link Reset
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100">
            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition flex items-center justify-center gap-2">
                &larr; Kembali ke Login
            </a>
        </div>
    </div>

</body>
</html>