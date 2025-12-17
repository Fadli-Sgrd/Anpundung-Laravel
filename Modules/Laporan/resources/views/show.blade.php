<x-layouts.app title="Detail Laporan">
    <div class="max-w-4xl mx-auto px-4">
        
        <a href="/laporan" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold mb-6 transition">
            <i class='bx bx-arrow-back'></i> Kembali ke Daftar
        </a>

        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[100px] -mr-4 -mt-4 opacity-50"></div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 mb-2">{{ $laporan->judul }}</h1>
                    <p class="text-slate-500 font-medium flex items-center gap-2">
                        <i class='bx bx-hash'></i> {{ $laporan->kode_laporan }}
                    </p>
                </div>
                
                @php
                    $statusClass = match($laporan->status_tindakan) {
                        'Pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                        'Proses' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'Selesai' => 'bg-green-100 text-green-700 border-green-200',
                        'Ditolak' => 'bg-red-100 text-red-700 border-red-200',
                        default => 'bg-slate-100 text-slate-700'
                    };
                @endphp
                <span class="px-4 py-2 rounded-xl text-sm font-bold uppercase tracking-wider border {{ $statusClass }}">
                    {{ $laporan->status_tindakan }}
                </span>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-8">
                
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-align-left text-blue-600'></i> Kronologi Kejadian
                    </h3>
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $laporan->deskripsi }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-image text-blue-600'></i> Bukti Lampiran
                    </h3>
                    
                    @if ($laporan->bukti->count() === 0)
                        <p class="text-slate-400 text-sm italic">Tidak ada bukti yang dilampirkan.</p>
                    @else
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($laporan->bukti as $b)
                                <div class="relative group rounded-xl overflow-hidden border border-slate-200">
                                    @if ($b->jenis === 'Gambar')
                                        <img src="{{ asset('storage/' . $b->path_file) }}" class="w-full h-40 object-cover hover:scale-105 transition duration-500" alt="Bukti">
                                    @else
                                        <div class="w-full h-40 bg-slate-900 flex items-center justify-center">
                                            <i class='bx bx-play-circle text-4xl text-white opacity-80'></i>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-3">
                                        <p class="text-white text-xs truncate">{{ $b->deskripsi ?? 'Tanpa Keterangan' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                    <h4 class="font-bold text-slate-700 mb-4 text-sm">Upload Bukti Tambahan</h4>
                    <form id="uploadBuktiForm" class="flex gap-3 items-start">
                        @csrf
                        <input type="hidden" name="kode_laporan" value="{{ $laporan->kode_laporan }}">
                        <input type="hidden" name="jenis" value="Gambar"> <input type="file" name="file" required class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-xs file:font-semibold
                            file:bg-blue-100 file:text-blue-700
                            file:cursor-pointer hover:file:bg-blue-200 transition">
                        
                        <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-slate-700 transition">
                            Upload
                        </button>
                    </form>
                    <p id="uploadResult" class="text-xs font-bold text-green-600 mt-2"></p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase mb-1">Tanggal</p>
                        <p class="text-sm font-bold text-slate-700 flex items-center gap-2">
                            <i class='bx bx-calendar'></i> {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase mb-1">Lokasi</p>
                        <p class="text-sm font-bold text-slate-700 flex items-center gap-2">
                            <i class='bx bx-map-pin'></i> {{ $laporan->alamat }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase mb-1">Pelapor</p>
                        <p class="text-sm font-bold text-slate-700 flex items-center gap-2">
                            <i class='bx bx-user-circle'></i> {{ $laporan->user->name }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase mb-1">Kategori</p>
                        <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold px-2 py-1 rounded">
                            {{ $laporan->kategori->nama_kategori }}
                        </span>
                    </div>
                </div>

                @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'admin')
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 text-white shadow-lg">
                        <h3 class="font-bold mb-4 flex items-center gap-2">
                            <i class='bx bx-shield-quarter'></i> Admin Control
                        </h3>
                        <form method="POST" action="/laporan/{{ $laporan->kode_laporan }}/status" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase">Update Status</label>
                                <select name="status_tindakan" class="w-full mt-1 bg-slate-700 border-none rounded-lg text-sm text-white focus:ring-2 focus:ring-blue-500 py-2.5">
                                    @foreach(['Pending', 'Proses', 'Selesai', 'Ditolak'] as $status)
                                        <option value="{{ $status }}" {{ $laporan->status_tindakan == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 rounded-lg text-sm transition">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById('uploadBuktiForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            const res = document.getElementById('uploadResult');
            
            btn.disabled = true;
            btn.innerText = '...';

            let formData = new FormData(this);

            fetch('/bukti', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    res.innerText = 'Berhasil! Refresh halaman...';
                    setTimeout(() => location.reload(), 1000);
                } else {
                    res.innerText = 'Gagal upload.';
                    res.classList.replace('text-green-600', 'text-red-600');
                }
            })
            .catch(() => {
                alert('Terjadi kesalahan.');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerText = 'Upload';
            });
        });
    </script>
</x-layouts.app>