<x-layouts.app title="Laporan Saya">
    <div class="max-w-5xl mx-auto px-4">
        
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Riwayat Laporan</h1>
                <p class="text-slate-500">Pantau status dan perkembangan aduan yang telah Anda kirim.</p>
            </div>
            <a href="/laporan/create" class="inline-flex items-center gap-2 bg-blue-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition transform hover:-translate-y-1">
                <i class='bx bx-plus-circle text-xl'></i> Buat Laporan Baru
            </a>
        </div>

        @if ($laporan->count() === 0)
            <div class="bg-white rounded-3xl border-2 border-dashed border-slate-200 p-16 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <i class='bx bx-notepad text-4xl'></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada laporan</h3>
                <p class="text-slate-500 mb-8 max-w-md mx-auto">Anda belum pernah membuat laporan pungli. Jika menemukan indikasi pungli, segera laporkan di sini.</p>
                <a href="/laporan/create" class="text-blue-600 font-bold hover:underline">Mulai Buat Laporan &rarr;</a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach ($laporan as $l)
                    <a href="/laporan/{{ $l->kode_laporan }}" class="group block bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-400 transition relative overflow-hidden">
                        <div class="absolute top-6 right-6">
                            @php
                                $statusClass = match($l->status_tindakan) {
                                    'Pending' => 'bg-yellow-100 text-yellow-700',
                                    'Proses' => 'bg-blue-100 text-blue-700',
                                    'Selesai' => 'bg-green-100 text-green-700',
                                    'Ditolak' => 'bg-red-100 text-red-700',
                                    default => 'bg-slate-100 text-slate-700'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $statusClass }}">
                                {{ $l->status_tindakan }}
                            </span>
                        </div>

                        <div class="pr-24"> <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition">{{ $l->judul }}</h3>
                            <div class="flex items-center gap-4 text-xs font-medium text-slate-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class='bx bx-calendar'></i> {{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class='bx bx-tag'></i> {{ $l->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>
                            <p class="text-slate-600 text-sm line-clamp-2 leading-relaxed">
                                {{ $l->deskripsi }}
                            </p>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400">Kode: #{{ $l->kode_laporan }}</span>
                            <span class="text-sm font-bold text-blue-600 flex items-center gap-1 group-hover:translate-x-1 transition">
                                Lihat Detail <i class='bx bx-right-arrow-alt'></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>