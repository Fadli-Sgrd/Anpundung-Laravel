<x-layouts.app title="Profile">
    <div class="max-w-4xl mx-auto">
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Profile Saya</h1>
            <p class="text-slate-500">Kelola informasi akun dan keamanan Anda</p>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <i class='bx bxs-check-circle text-xl'></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 text-center">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-4xl font-bold mb-4 shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h2 class="font-bold text-lg text-slate-800">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500 mb-4">{{ $user->email }}</p>
                    <div class="inline-block px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold uppercase">
                        {{ ucfirst($user->role) }}
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-slate-100 text-left">
                        <p class="text-xs text-slate-400 font-bold uppercase mb-3">Menu Cepat</p>
                        <a href="/laporan" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium">
                            <i class='bx bxs-file-doc text-lg'></i> Laporan Saya
                        </a>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-xl text-slate-800 mb-6 border-b border-slate-100 pb-4">Edit Informasi</h3>
                    
                    <form method="POST" action="/profile/update" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition font-medium text-slate-700">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition font-medium text-slate-700">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full md:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition transform active:scale-95 flex items-center justify-center gap-2">
                                <i class='bx bx-save'></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>