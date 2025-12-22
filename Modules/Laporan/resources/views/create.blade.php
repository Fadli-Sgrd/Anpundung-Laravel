<x-layouts.app title="Buat Laporan">

  <div class="max-w-3xl mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl shadow-2xl p-8">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Buat Laporan</h1>
        <a href="/" class="text-sm font-bold text-blue-600 hover:text-blue-700">Kembali</a>
      </div>

      <form action="/laporan" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
          <label class="block text-sm font-bold text-slate-700 mb-2">Judul Laporan</label>
          <input type="text" name="judul" required
            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
          @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Kejadian</label>
            <input type="date" name="tanggal" required
              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
            @error('tanggal') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
            <select name="id_kategori" required
              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
              <option value="">-- Pilih Kategori --</option>
              @foreach ($kategori as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
              @endforeach
            </select>
            @error('id_kategori') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>
        </div>

        <div>
          <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Kejadian</label>
          <input type="text" name="alamat" required
            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
          @error('alamat') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-bold text-slate-700 mb-2">Kronologi / Deskripsi</label>
          <textarea name="deskripsi" rows="5" required
            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl"></textarea>
          @error('deskripsi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-bold text-slate-700 mb-2">Bukti Pendukung</label>
          <input type="file" name="bukti[]" multiple accept="image/*,video/mp4"
            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
          @error('bukti') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl">
          <i class='bx bx-send text-xl'></i> Kirim Laporan
        </button>
      </form>
    </div>
  </div>


</x-layouts.app>
