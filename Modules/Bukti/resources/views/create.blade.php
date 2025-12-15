<x-layouts.app title="Upload Bukti">
    <div style="max-width: 700px; margin: 0 auto; padding: 0 16px;">
        <!-- Header -->
        <div style="margin-bottom: 48px;">
            <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 40px; color: #333; margin-bottom: 8px;">
                Upload Bukti
            </h1>
            <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 16px;">
                Tambahkan foto atau video sebagai bukti untuk laporan Anda
            </p>
        </div>

        <!-- Form Card -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee;">
            <form id="form-bukti" enctype="multipart/form-data">
                @csrf

                <!-- Kode Laporan -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Kode Laporan</label>
                    <input type="text" name="kode_laporan" value="{{ request('laporan') }}" placeholder="Masukkan kode laporan" required
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                </div>

                <!-- Jenis Bukti -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Jenis Bukti</label>
                    <select name="jenis" required
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Gambar">Gambar</option>
                        <option value="Video">Video</option>
                    </select>
                </div>

                <!-- File Input -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">File Bukti</label>
                    <input type="file" name="file" required accept="image/*,video/mp4"
                        style="width: 100%; padding: 12px; border: 2px dashed #308478; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                </div>

                <!-- Deskripsi -->
                <div style="margin-bottom: 32px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Deskripsi Bukti (Opsional)</label>
                    <textarea name="deskripsi" placeholder="Jelaskan apa yang ditunjukkan bukti ini..."
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box; min-height: 100px; resize: vertical;"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" style="width: 100%; background: #308478; color: white; padding: 12px; border: none; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="bx bx-cloud-upload" style="font-size: 18px;"></i> Upload Bukti
                </button>
            </form>
            <div id="msg" style="margin-top: 16px; font-family: 'Poppins', sans-serif; font-weight: 500; text-align: center;"></div>
        </div>
    </div>

    <script>
        document.getElementById('form-bukti').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch('/buktis', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        document.getElementById('msg').innerText = 'Bukti berhasil diupload';
                    }
                })
                .catch(err => console.error(err));
        });
    </script>
@endsection
