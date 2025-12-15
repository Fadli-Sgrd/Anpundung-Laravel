<x-layouts.app title="Home">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 16px; margin-top: 132px;">
        <!-- Hero Section -->
        <div
            style="background: linear-gradient(135deg, #308478 0%, #236b5b 100%); color: #F5F5F5; padding: 60px 32px; margin-bottom: 80px; border-radius: 12px;">
            <h1
                style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 48px; margin-bottom: 16px; line-height: 1.2;">
                Lawan Pungli Bersama Kami</h1>
            <p
                style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 18px; opacity: 0.95; margin-bottom: 32px;">
                Platform transparan untuk melaporkan dan memantau pungutan liar di RW 14 Bandung</p>
            @auth
                <a href="/laporan/create"
                    style="display: inline-block; background: white; color: #308478; padding: 12px 32px; border-radius: 6px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none;">
                    <i class='bx bxs-plus-circle' style="vertical-align: middle; margin-right: 4px; font-size: 18px;"></i>
                    Buat Laporan
                </a>
            @else
                <a href="/login"
                    style="display: inline-block; background: white; color: #308478; padding: 12px 32px; border-radius: 6px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none;">
                    <i class='bx bxs-log-in' style="vertical-align: middle; margin-right: 4px; font-size: 18px;"></i>
                    Login untuk Mulai
                </a>
            @endauth
        </div>

        <!-- Tentang Section -->
        <div style="margin-bottom: 80px;">
            <h2
                style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 36px; color: #333; margin-bottom: 24px;">
                Tentang ANPUNDUNG</h2>
            <div style="background: white; padding: 40px; border-radius: 12px; border-left: 5px solid #308478;">
                <p
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; font-size: 16px; line-height: 1.8; margin-bottom: 16px;">
                    ANPUNDUNG adalah platform pelaporan yang dibuat untuk masyarakat RW 14 Bandung. Tujuannya sederhana:
                    memberikan tempat aman bagi warga untuk melaporkan pungli (pungutan liar) tanpa takut.
                </p>
                <p
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; font-size: 16px; line-height: 1.8;">
                    Setiap laporan yang masuk akan ditangani dengan serius dan ditindaklanjuti oleh pihak yang
                    berwenang. Transparansi adalah kunci, dan kami berkomitmen untuk membuat proses ini se-jelas
                    mungkin.
                </p>
            </div>
        </div>

        <!-- Keuntungan Section -->
        <div style="margin-bottom: 80px;">
            <h2
                style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 36px; color: #333; margin-bottom: 32px;">
                Mengapa Menggunakan ANPUNDUNG?</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
                <div style="background: #f8f9fa; padding: 32px; border-radius: 12px;">
                    <div style="font-size: 32px; margin-bottom: 16px;"><i class="bx bx-lock"
                            style="font-size: 32px;"></i></div>
                    <h3
                        style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #333; margin-bottom: 12px;">
                        Aman & Terpercaya</h3>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; line-height: 1.6;">Data
                        Anda dilindungi dengan baik. Privasi Anda adalah prioritas kami.</p>
                </div>
                <div style="background: #f8f9fa; padding: 32px; border-radius: 12px;">
                    <div style="font-size: 32px; margin-bottom: 16px;"><i class="bx bx-show"
                            style="font-size: 32px;"></i></div>
                    <h3
                        style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #333; margin-bottom: 12px;">
                        Transparan & Akuntabel</h3>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; line-height: 1.6;">
                        Pantau perkembangan laporan Anda dari awal hingga akhir.</p>
                </div>
                <div style="background: #f8f9fa; padding: 32px; border-radius: 12px;">
                    <div style="font-size: 32px; margin-bottom: 16px;"><i class="bx bx-bolt"
                            style="font-size: 32px;"></i></div>
                    <h3
                        style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #333; margin-bottom: 12px;">
                        Cepat & Mudah</h3>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; line-height: 1.6;">
                        Hanya butuh beberapa menit untuk membuat laporan Anda.</p>
                </div>
            </div>
        </div>

        <!-- Edukasi Section -->
        <div style="margin-bottom: 80px;">
            <h2
                style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 36px; color: #333; margin-bottom: 32px;">
                Kenali Pungli Itu Apa</h2>

            <!-- Definisi -->
            <div
                style="background: white; padding: 32px; border-radius: 12px; border-left: 5px solid #308478; margin-bottom: 32px;">
                <h3
                    style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 22px; color: #333; margin-bottom: 16px;">
                    Definisi Pungli</h3>
                <p
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; font-size: 16px; line-height: 1.8;">
                    Pungli (pungutan liar) adalah pengumpulan uang atau sejenis pembayaran yang dilakukan secara paksa
                    atau dengan memanfaatkan kekuasaan, tanpa dasar hukum yang sah. Ini adalah tindakan korupsi yang
                    merugikan masyarakat.
                </p>
            </div>

            <!-- Ciri-ciri -->
            <div style="margin-bottom: 32px;">
                <h3
                    style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 22px; color: #333; margin-bottom: 16px;">
                    Ciri-Ciri Pungli yang Perlu Diwaspadai</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div style="background: white; padding: 24px; border-radius: 12px; border: 2px solid #eee;">
                        <div style="font-size: 24px; margin-bottom: 12px;"><i class="bx bx-x-circle"
                                style="font-size: 24px; color: #dc3545;"></i></div>
                        <h4
                            style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin-bottom: 8px;">
                            Tanpa Kwitansi Resmi</h4>
                        <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; font-size: 14px;">
                            Permintaan uang tanpa dokumen resmi dari lembaga</p>
                    </div>
                    <div style="background: white; padding: 24px; border-radius: 12px; border: 2px solid #eee;">
                        <div style="font-size: 24px; margin-bottom: 12px;"><i class="bx bx-lock-alt"
                                style="font-size: 24px; color: #ffc107;"></i></div>
                        <h4
                            style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin-bottom: 8px;">
                            Alasan Tidak Jelas</h4>
                        <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; font-size: 14px;">
                            Penjelasan vague atau membingungkan tentang tujuan uang</p>
                    </div>
                    <div style="background: white; padding: 24px; border-radius: 12px; border: 2px solid #eee;">
                        <div style="font-size: 24px; margin-bottom: 12px;"><i class="bx bx-alarm"
                                style="font-size: 24px; color: #dc3545;"></i></div>
                        <h4
                            style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin-bottom: 8px;">
                            Ada Ancaman</h4>
                        <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; font-size: 14px;">
                            Ancaman hukuman jika tidak membayar</p>
                    </div>
                    <div style="background: white; padding: 24px; border-radius: 12px; border: 2px solid #eee;">
                        <div style="font-size: 24px; margin-bottom: 12px;"><i class="bx bx-credit-card"
                                style="font-size: 24px;"></i></div>
                        <h4
                            style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin-bottom: 8px;">
                            Ke Rekening Pribadi</h4>
                        <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; font-size: 14px;">
                            Transfer ke rekening pribadi, bukan resmi</p>
                    </div>
                </div>
            </div>

            <!-- Cara Mencegah -->
            <div style="background: #f0f4ff; padding: 32px; border-radius: 12px; border-left: 5px solid #308478;">
                <h3
                    style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 22px; color: #333; margin-bottom: 16px;">
                    Bagaimana Cara Mencegahnya?</h3>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px; display: flex; gap: 12px;">
                        <i class="bx bx-check-circle" style="color: #308478; font-size: 20px;"></i>
                        <span style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">Pastikan
                            identitas orang yang minta uang</span>
                    </li>
                    <li style="margin-bottom: 12px; display: flex; gap: 12px;">
                        <i class="bx bx-check-circle" style="color: #308478; font-size: 20px;"></i>
                        <span style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">Minta
                            dokumentasi resmi sebelum membayar</span>
                    </li>
                    <li style="margin-bottom: 12px; display: flex; gap: 12px;">
                        <i class="bx bx-check-circle" style="color: #308478; font-size: 20px;"></i>
                        <span style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">Tanyakan nomor
                            rekening resmi ke kantor</span>
                    </li>
                    <li style="margin-bottom: 12px; display: flex; gap: 12px;">
                        <i class="bx bx-check-circle" style="color: #308478; font-size: 20px;"></i>
                        <span style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">Jangan malu
                            bertanya atau minta verifikasi</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- CTA Section -->
        <div
            style="background: linear-gradient(135deg, #308478 0%, #236b5b 100%); color: white; padding: 48px 32px; border-radius: 12px; text-align: center;">
            <h2 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 32px; margin-bottom: 16px;">
                Temukan Indikasi Pungli?</h2>
            <p
                style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 18px; margin-bottom: 32px; opacity: 0.95;">
                Jangan tunggu, laporkan sekarang. Laporan Anda akan membantu membangun komunitas yang lebih transparan
                dan adil.</p>
            @auth
                <a href="/laporan/create"
                    style="display: inline-block; background: white; color: #308478; padding: 12px 32px; border-radius: 6px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none; font-size: 16px;">
                    <i class='bx bxs-plus-circle' style="vertical-align: middle; margin-right: 4px; font-size: 18px;"></i>
                    Buat Laporan Sekarang
                </a>
            @else
                <a href="/register"
                    style="display: inline-block; background: white; color: #308478; padding: 12px 32px; border-radius: 6px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none; font-size: 16px;">
                    <i class='bx bxs-user-plus' style="vertical-align: middle; margin-right: 4px; font-size: 18px;"></i>
                    Daftar Sekarang
                </a>
            @endauth
        </div>
    </div>
</x-layouts.app>
