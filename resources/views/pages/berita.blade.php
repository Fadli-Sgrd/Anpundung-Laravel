<x-layouts.app title="Berita - Laporan Publik">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 16px;">
        <!-- Header -->
        <div style="margin-bottom: 64px;">
            <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 40px; color: #333; margin-bottom: 8px;">
                Laporan Publik
            </h1>
            <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 16px;">
                Lihat laporan pungli yang dilaporkan komunitas ANPUNDUNG
            </p>
        </div>

        @if ($laporan->count() === 0)
            <!-- Empty State -->
            <div style="background: white; padding: 48px 32px; border-radius: 12px; border: 2px solid #eee; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 16px;"><i class="bx bx-list-ul" style="font-size: 48px;"></i></div>
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #333; margin-bottom: 8px;">Belum ada laporan</h2>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; margin-bottom: 24px; font-size: 14px;">
                    Jadilah yang pertama melaporkan kasus pungli ke sistem ANPUNDUNG
                </p>
                <a href="/laporan/create" style="display: inline-flex; align-items: center; gap: 8px; background: #308478; color: white; padding: 10px 24px; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none; font-size: 14px;">
                    <i class="bx bx-plus-circle" style="font-size: 16px;"></i> Buat Laporan Pertama
                </a>
            </div>
        @else
            <!-- Reports List -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                @foreach ($laporan as $item)
                    <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee; border-left: 5px solid #308478;">
                        <!-- Title & Status -->
                        <div style="margin-bottom: 16px;">
                            <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 22px; color: #333; margin-bottom: 12px;">
                                {{ $item->judul }}
                            </h2>
                            <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                                <span style="background: 
                                    @if ($item->status_tindakan === 'Pending') #ffc107
                                    @elseif ($item->status_tindakan === 'Proses') #17a2b8
                                    @elseif ($item->status_tindakan === 'Selesai') #28a745
                                    @else #dc3545 @endif;
                                    color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    {{ $item->status_tindakan }}
                                </span>
                                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 13px; margin: 0;">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }} • {{ $item->kategori->nama_kategori }}
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; line-height: 1.8; margin-bottom: 16px;">
                            {{ Str::limit($item->deskripsi, 250) }}
                        </p>

                        <!-- Location & Reporter -->
                        <div style="background: #f8f9fa; padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                            <div style="display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                                <div>
                                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 12px; margin: 0 0 4px 0;">Lokasi</p>
                                    <p style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin: 0;"><i class="bx bx-map" style="vertical-align: middle; margin-right: 4px;"></i> {{ $item->alamat }}</p>
                                </div>
                                <div>
                                    <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 12px; margin: 0 0 4px 0;">Pelapor</p>
                                    <p style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; margin: 0;"><i class="bx bx-user" style="vertical-align: middle; margin-right: 4px;"></i> {{ $item->user->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Evidence -->
                        @if ($item->bukti->count() > 0)
                            <div style="margin-bottom: 16px;">
                                <p style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 14px; margin-bottom: 12px;">
                                    <i class="bx bx-image" style="vertical-align: middle; margin-right: 4px;"></i> Bukti ({{ $item->bukti->count() }} file)
                                </p>
                                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                    @foreach ($item->bukti->take(4) as $b)
                                        @if ($b->jenis === 'Gambar')
                                            <img src="{{ asset('storage/' . $b->path_file) }}" alt="Bukti" style="height: 80px; width: 80px; border-radius: 8px; object-fit: cover; border: 1px solid #eee;">
                                        @else
                                            <div style="height: 80px; width: 80px; background: #333; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px;">
                                                <i class="bx bx-video" style="font-size: 32px;"></i>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <a href="#" style="display: inline-block; background: #308478; color: white; padding: 8px 16px; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none; font-size: 13px;">
                            Baca Selengkapnya
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>
