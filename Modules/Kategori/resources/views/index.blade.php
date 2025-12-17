<x-layouts.app title="Kelola Kategori">
    <div class="max-w-6xl mx-auto px-4"> <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Kategori Laporan</h1>
                <p class="text-slate-500">Atur jenis-jenis pelanggaran yang dapat dilaporkan warga.</p>
            </div>
            <a href="/kategoris/create" class="inline-flex items-center gap-2 bg-blue-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition transform hover:-translate-y-1">
                <i class='bx bx-plus-circle text-xl'></i> Tambah Kategori
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl font-bold flex items-center gap-2">
                <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            @if(isset($kategoris) && count($kategoris) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                                <th class="p-6 font-bold w-16">No</th>
                                <th class="p-6 font-bold w-1/4">Nama Kategori</th>
                                <th class="p-6 font-bold">Deskripsi</th> <th class="p-6 font-bold text-right w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($kategoris as $index => $k)
                                <tr class="hover:bg-blue-50/50 transition">
                                    <td class="p-6 font-bold text-slate-500">{{ $index + 1 }}</td>
                                    <td class="p-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg shrink-0">
                                                {{ substr($k->nama_kategori, 0, 1) }}
                                            </div>
                                            <span class="font-bold text-slate-700 text-base">{{ $k->nama_kategori }}</span>
                                        </div>
                                    </td>
                                    <td class="p-6 text-slate-600 text-sm">
                                        {{ $k->deskripsi ?? '-' }}
                                    </td>
                                    <td class="p-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="/kategoris/{{ $k->id }}/edit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
                                                <i class='bx bx-edit-alt'></i>
                                            </a>
                                            <form action="/kategoris/{{ $k->id }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition" title="Hapus">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i class='bx bx-purchase-tag-alt text-4xl'></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Belum ada kategori</h3>
                    <p class="text-slate-500 text-sm">Silakan tambahkan kategori pelanggaran baru.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>