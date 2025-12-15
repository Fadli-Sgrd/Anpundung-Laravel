<x-layouts.app title="Buat Laporan">
    <div style="max-width: 700px; margin: 0 auto; padding: 0 16px;">
        <!-- Header -->
        <div style="margin-bottom: 48px;">
            <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 40px; color: #333; margin-bottom: 8px;">
                Buat Laporan
            </h1>
            <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 16px;">
                Laporkan indikasi pungli yang Anda alami atau saksikan
            </p>
        </div>

        <!-- Error/Success Messages -->
        <div id="msg" style="margin-bottom: 24px;"></div>

        <!-- Form Card -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee;">
            <form id="form-laporan" enctype="multipart/form-data">
                @csrf

                <!-- Judul -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Judul Laporan</label>
                    <input type="text" name="judul" placeholder="Contoh: Pungli di sekolah" required
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                </div>

                <!-- Tanggal -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Tanggal Kejadian</label>
                    <input type="date" name="tanggal" required
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                </div>

                <!-- Alamat -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Alamat / Lokasi</label>
                    <input type="text" name="alamat" placeholder="Contoh: Jl. Merdeka No. 123, RW 14" required
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                </div>

                <!-- Kategori -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Kategori Pungli</label>
                    <select name="id_kategori" required
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Deskripsi -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Deskripsi Kejadian</label>
                    <textarea name="deskripsi" placeholder="Jelaskan dengan detail apa yang terjadi..." required
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box; min-height: 120px; resize: vertical;"></textarea>
                </div>

                <!-- Bukti Upload -->
                <div style="margin-bottom: 32px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Upload Bukti (Opsional)</label>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 400; color: #999; font-size: 13px; margin: 0 0 12px 0;">
                        Foto atau video bukti pungli (maksimal 5MB per file)
                    </p>
                    <input type="file" id="bukti" name="bukti[]" multiple accept="image/*,video/mp4"
                        style="width: 100%; padding: 12px; border: 2px dashed #308478; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                </div>

                <!-- Submit Button -->
                <button type="submit" style="width: 100%; background: #308478; color: white; padding: 12px; border: none; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="bx bx-send" style="font-size: 18px;"></i> Kirim Laporan
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('form-laporan').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch('/laporan', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                        if (res.success) {
                            window.location.href = '/laporan/' + res.kode_laporan;
                        } else {
                            document.getElementById('msg').innerText = 'Gagal kirim laporan';
                        }
                })
                .catch(err => console.error(err));
        });
    </script>
</x-layouts.app>
