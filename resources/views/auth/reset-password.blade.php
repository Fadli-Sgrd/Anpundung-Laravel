<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Password Baru</h2>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 cursor-not-allowed" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Password Baru</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Minimal 8 karakter" required>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Ulangi Password</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-blue-700 transition-all">
                Simpan Password
            </button>
        </form>
    </div>

</body>
</html>