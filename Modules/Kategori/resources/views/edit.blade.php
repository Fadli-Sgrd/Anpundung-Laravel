<x-layouts.app title="Edit Kategori">
    <div class="max-w-2xl mx-auto px-4">
        <a href="/kategoris" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold mb-8 transition">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>

        <div class="bg-white rounded-3xl shadow-lg shadow-blue-50 border border-slate-100 p-8 md:p-10">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Edit Kategori</h1>
                <p class="text-slate-500 text-sm">Perbarui informasi kategori pelanggaran.</p>
            </div>

            <form action="/kategoris/{{ $kategori->id }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label value="Nama Kategori" />
                    <x-text-input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required class="px-4 py-3" />
                </div>

                <div>
                    <x-input-label value="Deskripsi (Opsional)" />
                    <x-textarea name="deskripsi" rows="3" placeholder="Jelaskan singkat tentang kategori ini..." class="px-4 py-3">{{ old('deskripsi', $kategori->deskripsi) }}</x-textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <a href="/kategoris" class="w-full bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold py-3.5 rounded-xl transition flex items-center justify-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 transition transform active:scale-95 flex items-center justify-center gap-2">
                        <i class='bx bx-save text-xl'></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>