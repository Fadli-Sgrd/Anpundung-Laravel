<x-layouts.app title="Daftar Bukti">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 16px;">
        <!-- Header -->
        <div style="margin-bottom: 64px;">
            <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 40px; color: #333; margin-bottom: 8px;">
                Kelola Bukti
            </h1>
            <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 16px;">
                Upload dan kelola bukti pendukung laporan Anda
            </p>
        </div>

        <!-- Info Box -->
        <div style="background: #f0f4ff; padding: 24px; border-radius: 12px; border-left: 5px solid #308478; margin-bottom: 40px;">
            <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 16px; color: #333; margin-bottom: 12px;"><i class="bx bx-image" style="vertical-align: middle; margin-right:8px; color:#308478;"></i> Jenis Bukti yang Diterima</h3>
            <ul style="list-style: none; padding: 0; margin: 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                <li style="margin-bottom: 8px; display: flex; gap: 8px; align-items: center;">
                    <i class="bx bx-check-circle" style="color: #308478; font-size: 16px;"></i>
                    <span>Foto (JPG, PNG) - Maksimal 5MB</span>
                </li>
                <li style="margin-bottom: 8px; display: flex; gap: 8px; align-items: center;">
                    <i class="bx bx-check-circle" style="color: #308478; font-size: 16px;"></i>
                    <span>Video (MP4) - Maksimal 5MB</span>
                </li>
                <li style="display: flex; gap: 8px; align-items: center;">
                    <i class="bx bx-check-circle" style="color: #308478; font-size: 16px;"></i>
                    <span>Sertakan deskripsi jelas untuk setiap bukti</span>
                </li>
            </ul>
        </div>

        <!-- Upload Form -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee;">
            <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #333; margin-bottom: 24px;"><i class="bx bx-cloud-upload" style="vertical-align: middle; margin-right:8px; color:#308478;"></i> Upload Bukti Baru</h2>
            
            <form id="uploadBuktiForm" enctype="multipart/form-data">
                @csrf

                <!-- Laporan Selection -->
                <div style="margin-bottom: 24px;">
                    <x-input-label value="Pilih Laporan" />
                    <x-text-input type="text" name="kode_laporan" placeholder="Masukkan kode laporan atau buka dari halaman detail laporan" required class="p-3" />
                </div>

                <!-- Jenis Bukti -->
                <div style="margin-bottom: 24px;">
                    <x-input-label value="Jenis Bukti" />
                    <select name="jenis" required
                        class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 p-3">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Gambar">Gambar</option>
                        <option value="Video">Video</option>
                    </select>
                </div>

                <!-- File Input -->
                <div style="margin-bottom: 24px;">
                    <x-input-label value="File Bukti" />
                    <input type="file" name="file" required accept="image/*,video/mp4"
                        class="w-full px-4 py-3 bg-white border-2 border-dashed border-teal-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20 cursor-pointer">
                </div>

                <!-- Description -->
                <div style="margin-bottom: 24px;">
                    <x-input-label value="Deskripsi Bukti (Opsional)" />
                    <x-textarea name="deskripsi" placeholder="Jelaskan apa yang ditunjukkan bukti ini..." style="min-height: 80px;" class="p-3"></x-textarea>
                </div>

                <!-- Submit -->
                <button type="submit" style="width: 100%; background: #308478; color: white; padding: 12px; border: none; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="bx bx-cloud-upload" style="font-size: 18px;"></i> Upload Bukti
                </button>
            </form>
            <div id="msg" style="margin-top: 16px; font-family: 'Poppins', sans-serif; font-weight: 500; text-align: center;"></div>
        </div>
    </div>
</x-layouts.app>
