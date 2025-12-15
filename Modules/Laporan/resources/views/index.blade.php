<x-layouts.app title="Daftar Laporan">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 16px;">
        <!-- Header -->
        <div style="margin-bottom: 64px;">
            <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 40px; color: #333; margin-bottom: 8px;">
                Laporan Saya
            </h1>
            <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 16px;">
                Pantau status laporan pungli yang Anda buat
            </p>
        </div>

        @if ($laporan->count() === 0)
                <!-- Empty State -->
            <div style="background: white; padding: 48px 32px; border-radius: 12px; border: 2px solid #eee; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 16px; color: #308478;"><i class="bx bx-clipboard" style="font-size:48px; vertical-align: middle;"></i></div>
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #333; margin-bottom: 8px;">Belum ada laporan</h2>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; margin-bottom: 24px; font-size: 14px;">
                    Anda belum membuat laporan apapun. Mulai buat laporan sekarang!
                </p>
                <a href="/laporan/create" style="display: inline-block; background: #308478; color: white; padding: 10px 24px; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none; font-size: 14px;">
                    Buat Laporan Baru
                </a>
            </div>
        @else
            <!-- Reports List -->
            <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 32px;">
                @foreach ($laporan as $l)
                    <a href="/laporan/{{ $l->kode_laporan }}" style="display: block; background: white; padding: 24px; border-radius: 12px; border: 2px solid #eee; text-decoration: none; transition: all 0.2s ease; border-left: 5px solid #308478;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px;">
                            <div>
                                <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 8px;">
                                    {{ $l->judul }}
                                </h3>
                                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 13px; margin: 0;">
                                    {{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }} • {{ $l->kategori->nama_kategori ?? 'N/A' }}
                                </p>
                            </div>
                            <span style="background: 
                                @if ($l->status_tindakan === 'Pending') #ffc107
                                @elseif ($l->status_tindakan === 'Proses') #17a2b8
                                @elseif ($l->status_tindakan === 'Selesai') #28a745
                                @else #dc3545 @endif;
                                color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-family: 'Poppins', sans-serif; font-weight: 600; white-space: nowrap;">
                                {{ $l->status_tindakan }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Create New Report Button -->
            <div style="text-align: center;">
                <a href="/laporan/create" style="display: inline-block; background: #308478; color: white; padding: 10px 24px; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none; font-size: 14px;">
                    <i class="bx bx-plus" style="font-size: 20px;"></i> Buat Laporan Baru
                </a>
            </div>
        @endif
    </div>
</x-layouts.app>
