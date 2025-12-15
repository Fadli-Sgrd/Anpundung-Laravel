<x-layouts.app title="Dashboard">
    @php $user = Illuminate\Support\Facades\Auth::user() @endphp

    @if ($user->role === 'admin')
        {{-- ADMIN DASHBOARD --}}
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 16px;">
            <!-- Welcome Section -->
            <div style="margin-bottom: 64px;">
                <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 40px; color: #333; margin-bottom: 8px;">
                    Selamat datang, {{ explode(' ', $user->name)[0] }}!
                </h1>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 16px;">
                    Kelola laporan dan kategori sistem ANPUNDUNG
                </p>
            </div>

            <!-- Quick Stats -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 64px;">
                <div style="background: linear-gradient(135deg, #308478 0%, #236b5b 100%); padding: 32px; border-radius: 12px; color: white;">
                    <div style="font-size: 32px; margin-bottom: 16px;"><i class="bx bx-bar-chart" style="font-size: 32px;"></i></div>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; opacity: 0.9; margin-bottom: 8px;">Total Laporan</p>
                    <div style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 28px;">12</div>
                </div>
                <div style="background: #f8f9fa; padding: 32px; border-radius: 12px; border-left: 4px solid #ffc107;">
                    <div style="font-size: 32px; margin-bottom: 16px;"><i class="bx bx-time" style="font-size: 32px;"></i></div>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; color: #999; margin-bottom: 8px;">Menunggu</p>
                    <div style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 28px; color: #333;">3</div>
                </div>
                <div style="background: #f8f9fa; padding: 32px; border-radius: 12px; border-left: 4px solid #28a745;">
                    <div style="font-size: 32px; margin-bottom: 16px;"><i class="bx bx-check-circle" style="font-size: 32px;"></i></div>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; color: #999; margin-bottom: 8px;">Selesai</p>
                    <div style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 28px; color: #333;">9</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="margin-bottom: 40px;">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 24px; color: #333; margin-bottom: 20px;">Aksi Cepat</h2>
                <div style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    <a href="/laporan" style="display: block; background: white; padding: 28px; border-radius: 12px; border: 2px solid #eee; text-decoration: none; transition: all 0.2s ease;">
                        <div style="font-size: 32px; margin-bottom: 12px;"><i class="bx bx-list-check" style="font-size: 32px;"></i></div>
                        <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin-bottom: 8px;">Kelola Laporan</h3>
                        <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 14px;">Tinjau dan proses semua laporan</p>
                    </a>
                    <a href="/kategoris" style="display: block; background: white; padding: 28px; border-radius: 12px; border: 2px solid #eee; text-decoration: none; transition: all 0.2s ease;">
                        <div style="font-size: 32px; margin-bottom: 12px;"><i class="bx bx-tag" style="font-size: 32px;"></i></div>
                        <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin-bottom: 8px;">Kategori</h3>
                        <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 14px;">Atur kategori laporan</p>
                    </a>
                </div>
            </div>

            <!-- Admin Info -->
            <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee;">
                <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 16px;">Info Akun</h3>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                    <span>Nama</span>
                    <span>{{ $user->name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                    <span>Email</span>
                    <span>{{ $user->email }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                    <span>Role</span>
                    <span style="color: #308478; font-weight: 600;">Administrator</span>
                </div>
            </div>
        </div>
    @else
        {{-- USER DASHBOARD --}}
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 16px;">
            <!-- Welcome Section -->
            <div style="margin-bottom: 64px;">
                <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 40px; color: #333; margin-bottom: 8px;">
                    Halo, {{ explode(' ', $user->name)[0] }}!
                </h1>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 16px;">
                    Buat dan pantau laporan pungli Anda di sini
                </p>
            </div>

            <!-- Main Actions -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 64px;">
                <!-- Create Report -->
                <a href="/laporan/create" style="display: block; background: linear-gradient(135deg, #308478 0%, #236b5b 100%); padding: 40px 32px; border-radius: 12px; text-decoration: none; color: white; transition: all 0.2s ease;">
                    <div style="font-size: 40px; margin-bottom: 16px;"><i class="bx bx-plus-circle" style="font-size: 40px;"></i></div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; margin-bottom: 8px;">Buat Laporan</h3>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; opacity: 0.95;">Laporkan indikasi pungli yang Anda temui</p>
                </a>

                <!-- View Reports -->
                <a href="/laporan" style="display: block; background: white; padding: 40px 32px; border-radius: 12px; text-decoration: none; border: 2px solid #eee; transition: all 0.2s ease;">
                    <div style="font-size: 40px; margin-bottom: 16px;"><i class="bx bx-list-ul" style="font-size: 40px;"></i></div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #333; margin-bottom: 8px;">Laporan Saya</h3>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; color: #999;">Lihat status laporan yang sudah dibuat</p>
                </a>

                <!-- Guide -->
                <a href="/#edukasi" style="display: block; background: white; padding: 40px 32px; border-radius: 12px; text-decoration: none; border: 2px solid #eee; transition: all 0.2s ease;">
                    <div style="font-size: 40px; margin-bottom: 16px;"><i class="bx bx-book-open" style="font-size: 40px;"></i></div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #333; margin-bottom: 8px;">Pelajari</h3>
                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; color: #999;">Ketahui cara mencegah pungli</p>
                </a>
            </div>

            <!-- Info Box -->
            <div style="background: #f0f4ff; padding: 32px; border-radius: 12px; border-left: 5px solid #308478; margin-bottom: 40px;">
                <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 12px;"><i class="bx bx-bulb" style="font-size: 20px; vertical-align: middle; margin-right: 8px;"></i> Tips</h3>
                <ul style="list-style: none; padding: 0; margin: 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                    <li style="margin-bottom: 8px; display: flex; gap: 8px;">
                        <i class="bx bx-check" style="color: #308478; font-size: 18px;"></i>
                        <span>Sertakan bukti berupa foto atau video jika ada</span>
                    </li>
                    <li style="margin-bottom: 8px; display: flex; gap: 8px;">
                        <i class="bx bx-check" style="color: #308478; font-size: 18px;"></i>
                        <span>Jelaskan dengan detail apa yang terjadi dan kapan</span>
                    </li>
                    <li style="display: flex; gap: 8px;">
                        <i class="bx bx-check" style="color: #308478; font-size: 18px;"></i>
                        <span>Laporan Anda akan ditangani dengan serius dan aman</span>
                    </li>
                </ul>
            </div>

            <!-- Account Info -->
            <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee;">
                <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 16px;">Info Akun</h3>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                    <span>Nama</span>
                    <span>{{ $user->name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                    <span>Email</span>
                    <span>{{ $user->email }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                    <span>Bergabung</span>
                    <span>{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    @endif
</x-layouts.app>
