<x-layouts.app title="Detail Laporan">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 16px;">
        <!-- Header with Status -->
        <div style="margin-bottom: 48px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 16px;">
                <div>
                    <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 40px; color: #333; margin-bottom: 8px;">
                        {{ $laporan->judul }}
                    </h1>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 14px; margin: 0;">
                        Kode: {{ $laporan->kode_laporan }}
                    </p>
                </div>
                <span style="background: 
                    @if ($laporan->status_tindakan === 'Pending') #ffc107
                    @elseif ($laporan->status_tindakan === 'Proses') #17a2b8
                    @elseif ($laporan->status_tindakan === 'Selesai') #28a745
                    @else #dc3545 @endif;
                    color: white; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-family: 'Poppins', sans-serif; font-weight: 600; white-space: nowrap;">
                    {{ $laporan->status_tindakan }}
                </span>
            </div>
        </div>

        <!-- Main Info Card -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee; margin-bottom: 32px;">
            <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 20px;">Informasi Laporan</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
                <div style="border-bottom: 1px solid #eee; padding-bottom: 16px;">
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 12px; margin: 0 0 4px 0;">Tanggal Kejadian</p>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin: 0;"><i class="bx bx-calendar" style="vertical-align: middle; margin-right:8px; color:#308478;"></i> {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</p>
                </div>
                <div style="border-bottom: 1px solid #eee; padding-bottom: 16px;">
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 12px; margin: 0 0 4px 0;">Kategori</p>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin: 0;"><i class="bx bx-tag" style="vertical-align: middle; margin-right:8px; color:#308478;"></i> {{ $laporan->kategori->nama_kategori }}</p>
                </div>
                <div style="border-bottom: 1px solid #eee; padding-bottom: 16px;">
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 12px; margin: 0 0 4px 0;">Pelapor</p>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin: 0;"><i class="bx bx-user" style="vertical-align: middle; margin-right:8px; color:#308478;"></i> {{ $laporan->user->name }}</p>
                </div>
                <div style="border-bottom: 1px solid #eee; padding-bottom: 16px;">
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 12px; margin: 0 0 4px 0;">Lokasi</p>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin: 0;"><i class="bx bx-map-pin" style="vertical-align: middle; margin-right:8px; color:#308478;"></i> {{ $laporan->alamat }}</p>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee; margin-bottom: 32px;">
            <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 16px;">Deskripsi</h2>
            <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; line-height: 1.8; margin: 0;">
                {{ $laporan->deskripsi }}
            </p>
        </div>

        <!-- Evidence -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee; margin-bottom: 32px;">
            <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 20px;"><i class="bx bx-image" style="vertical-align: middle; margin-right:8px; color:#308478;"></i> Bukti</h2>
            
            @if ($laporan->bukti->count() === 0)
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; text-align: center; padding: 32px 0; margin: 0;">
                    Belum ada bukti yang diupload
                </p>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                    @foreach ($laporan->bukti as $b)
                        <div style="border-radius: 8px; overflow: hidden; border: 1px solid #eee;">
                            @if ($b->jenis === 'Gambar')
                                <img src="{{ asset('storage/' . $b->path_file) }}" style="width: 100%; height: 180px; object-fit: cover;" alt="Bukti">
                            @else
                                <video width="100%" height="180" style="background: #333;" controls>
                                    <source src="{{ asset('storage/' . $b->path_file) }}">
                                </video>
                            @endif
                            @if ($b->deskripsi)
                                <div style="padding: 12px; background: #f8f9fa;">
                                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; font-size: 12px; margin: 0;">
                                        {{ $b->deskripsi }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ================= ADMIN SECTION ================= --}}
        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'admin')
            <div style="background: #f0f4ff; padding: 32px; border-radius: 12px; border-left: 5px solid #308478; margin-bottom: 32px;">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 20px;"><i class="bx bx-cog" style="font-size: 20px; vertical-align: middle; margin-right: 8px;"></i> Update Status (Admin)</h2>
                
                <form method="POST" action="/laporan/{{ $laporan->kode_laporan }}/status" style="display: flex; gap: 12px; align-items: flex-end;">
                    @csrf
                    @method('PATCH')

                    <div style="flex: 1;">
                        <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px; font-size: 14px;">Status Tindakan</label>
                        <select name="status_tindakan" required
                            style="width: 100%; padding: 10px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px;">
                            <option value="Pending" {{ $laporan->status_tindakan === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Proses" {{ $laporan->status_tindakan === 'Proses' ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ $laporan->status_tindakan === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Ditolak" {{ $laporan->status_tindakan === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" style="background: #308478; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                        <i class="bx bx-check" style="font-size: 16px;"></i> Perbarui
                    </button>
                </form>
            </div>
        @endif
        {{-- ================= END ADMIN ================= --}}

        <!-- Upload Additional Evidence -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee; margin-bottom: 32px;">
            <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 20px;"><i class="bx bx-upload" style="vertical-align: middle; margin-right:8px; color:#308478;"></i> Tambah Bukti</h2>
            
            <form id="uploadBuktiForm">
                @csrf
                <input type="hidden" name="kode_laporan" value="{{ $laporan->kode_laporan }}">

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px; font-size: 14px;">Jenis Bukti</label>
                    <select name="jenis" required
                        style="width: 100%; padding: 10px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px;">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Gambar">Gambar</option>
                        <option value="Video">Video</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px; font-size: 14px;">File</label>
                    <input type="file" name="file" required
                        style="width: 100%; padding: 10px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px; font-size: 14px;">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" placeholder="Jelaskan bukti ini..."
                        style="width: 100%; padding: 10px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; min-height: 80px; resize: vertical;"></textarea>
                </div>

                <button type="submit" style="background: #308478; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; cursor: pointer; font-size: 14px;">
                    Upload Bukti
                </button>
            </form>
        </div>

        <!-- Back Button -->
        <div style="text-align: center;">
            <a href="/laporan" style="display: inline-flex; align-items: center; gap: 6px; background: #eee; color: #333; padding: 10px 24px; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none; font-size: 14px;">
                <i class="bx bx-arrow-back" style="font-size: 16px;"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- AJAX SCRIPT --}}
    <script>
        document.getElementById('uploadBuktiForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch('/bukti', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('uploadResult').innerText =
                            'Bukti berhasil diupload. Refresh halaman.';
                    }
                })
                .catch(() => {
                    alert('Upload gagal');
                });
        });
    </script>
</x-layouts.app>
