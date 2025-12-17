<x-layouts.app title="Laporan Publik">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-4">Laporan Publik</h1>
            <p class="text-slate-500 text-lg">Transparansi aduan masyarakat demi lingkungan bebas pungli.</p>
        </div>

        @if ($laporan->count() === 0)
            <div class="bg-white p-12 rounded-3xl border border-slate-100 text-center shadow-sm">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 text-4xl">
                    <i class='bx bx-folder-open'></i>
                </div>
                <h3 class="font-bold text-xl text-slate-800 mb-2">Belum ada laporan publik</h3>
                <p class="text-slate-500 mb-8">Jadilah yang pertama berkontribusi.</p>
                <a href="/laporan/create" class="inline-block px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    Buat Laporan
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($laporan as $item)
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-4">
                            <div>
                                <h2 class="text-xl font-bold text-slate-800 mb-2">{{ $item->judul }}</h2>
                                <div class="flex items-center gap-3 text-xs font-medium text-slate-500">
                                    <span class="flex items-center gap-1"><i class='bx bx-calendar'></i> {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</span>
                                    <span>•</span>
                                    <span class="text-blue-600">{{ $item->kategori->nama_kategori }}</span>
                                </div>
                            </div>
                            @php
                                $statusColors = [
                                    'Pending' => 'bg-yellow-100 text-yellow-700',
                                    'Proses' => 'bg-blue-100 text-blue-700',
                                    'Selesai' => 'bg-green-100 text-green-700',
                                    'Ditolak' => 'bg-red-100 text-red-700'
                                ];
                                $colorClass = $statusColors[$item->status_tindakan] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider h-fit w-fit {{ $colorClass }}">
                                {{ $item->status_tindakan }}
                            </span>
                        </div>

                        <p class="text-slate-600 leading-relaxed mb-6">{{ Str::limit($item->deskripsi, 200) }}</p>

                        <div class="bg-slate-50 rounded-xl p-4 flex flex-wrap gap-6 mb-6">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i class='bx bxs-map text-blue-500'></i>
                                <span class="font-medium">{{ $item->alamat }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i class='bx bxs-user-circle text-blue-500'></i>
                                <span>{{ $item->user->name }}</span>
                            </div>
                        </div>

                        @if ($item->bukti->count() > 0)
                            <div class="mb-6">
                                <p class="text-xs font-bold text-slate-400 uppercase mb-3">Lampiran Bukti</p>
                                <div class="flex gap-2">
                                    @foreach ($item->bukti->take(3) as $b)
                                        @if ($b->jenis === 'Gambar')
                                            <img src="{{ asset('storage/' . $b->path_file) }}" class="w-16 h-16 object-cover rounded-lg border border-slate-200">
                                        @else
                                            <div class="w-16 h-16 bg-slate-800 rounded-lg flex items-center justify-center text-white"><i class='bx bx-video'></i></div>
                                        @endif
                                    @endforeach
                                    @if($item->bukti->count() > 3)
                                        <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500 text-xs font-bold">+{{ $item->bukti->count() - 3 }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <button class="text-blue-600 font-bold text-sm hover:underline flex items-center gap-1">
                            Lihat Detail <i class='bx bx-right-arrow-alt'></i>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>