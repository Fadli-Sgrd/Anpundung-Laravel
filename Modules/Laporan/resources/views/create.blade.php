<x-layouts.app title="Buat Laporan">
    <div class="max-w-3xl mx-auto px-4">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Buat Laporan Baru</h1>
            <p class="text-slate-500">Sampaikan detail kejadian dengan jelas agar mudah ditindaklanjuti.</p>
        </div>

        <div id="msg" class="hidden mb-6 p-4 rounded-xl text-sm font-bold"></div>

        <div class="bg-white rounded-3xl shadow-lg shadow-blue-50 border border-slate-100 p-8 md:p-10">
            <form id="form-laporan" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Judul Laporan</label>
                    <input type="text" name="judul" placeholder="Contoh: Pungutan parkir liar di pasar" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-slate-700 font-medium">
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Kejadian</label>
                        <input type="date" name="tanggal" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-slate-700 font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                        <select name="id_kategori" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-slate-700 font-medium">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Kejadian</label>
                    <div class="relative">
                        <i class='bx bx-map absolute left-4 top-3.5 text-slate-400 text-lg'></i>
                        <input type="text" name="alamat" placeholder="Nama jalan, gedung, atau patokan..." required
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-slate-700 font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kronologi / Deskripsi</label>
                    <textarea name="deskripsi" rows="5" placeholder="Jelaskan secara rinci apa yang terjadi..." required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-slate-700 font-medium"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Bukti Pendukung</label>
                    <div class="relative border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 transition cursor-pointer group">
                        <input type="file" name="bukti[]" multiple accept="image/*,video/mp4" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <i class='bx bx-cloud-upload text-4xl text-slate-400 group-hover:text-blue-500 transition mb-2'></i>
                        <p class="text-sm font-bold text-slate-600">Klik untuk upload foto/video</p>
                        <p class="text-xs text-slate-400 mt-1">Maksimal 5MB per file</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-200 transition transform active:scale-95 flex items-center justify-center gap-2 mt-4">
                    <i class='bx bx-send text-xl'></i> Kirim Laporan
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('form-laporan').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            const msgBox = document.getElementById('msg');
            
            // Loading State
            btn.disabled = true;
            btn.innerHTML = '<i class="bx bx-loader-alt animate-spin text-xl"></i> Mengirim...';

            let formData = new FormData(this);

            fetch('/laporan', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    window.location.href = '/laporan/' + res.kode_laporan;
                } else {
                    msgBox.classList.remove('hidden', 'bg-green-100', 'text-green-700');
                    msgBox.classList.add('flex', 'bg-red-100', 'text-red-700');
                    msgBox.innerText = 'Gagal mengirim laporan. Silakan cek inputan Anda.';
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bx bx-send text-xl"></i> Kirim Laporan';
                }
            })
            .catch(err => {
                console.error(err);
                btn.disabled = false;
                btn.innerHTML = '<i class="bx bx-send text-xl"></i> Kirim Laporan';
            });
        });
    </script>
</x-layouts.app>