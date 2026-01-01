<x-layouts.app title="Kelola Kategori">
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Kategori Laporan</h1>
                <p class="text-slate-500">Atur jenis-jenis pelanggaran yang dapat dilaporkan warga.</p>
            </div>
            <x-primary-button href="/kategoris/create">
                <i class='bx bx-plus-circle text-xl'></i> Tambah Kategori
            </x-primary-button>
        </div>

        @if (session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

            @if(isset($kategoris) && count($kategoris) > 0)
                <x-table.index>
                    <x-table.thead>
                        <tr>
                            <x-table.th class="w-16">No</x-table.th>
                            <x-table.th class="w-1/4">Nama Kategori</x-table.th>
                            <x-table.th>Deskripsi</x-table.th>
                            <x-table.th class="text-right w-32">Aksi</x-table.th>
                        </tr>
                    </x-table.thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($kategoris as $index => $k)
                            <tr class="hover:bg-blue-50/50 transition">
                                <x-table.td class="font-bold text-slate-500">{{ $index + 1 }}</x-table.td>
                                <x-table.td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg shrink-0">
                                            {{ substr($k->nama_kategori, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-slate-700 text-base">{{ $k->nama_kategori }}</span>
                                    </div>
                                </x-table.td>
                                <x-table.td class="text-slate-600 text-sm">
                                    {{ $k->deskripsi ?? '-' }}
                                </x-table.td>
                                <x-table.td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="/kategoris/{{ $k->id }}/edit" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm" title="Edit">
                                            <i class='bx bx-edit-alt text-xl'></i>
                                        </a>
                                        <form action="/kategoris/{{ $k->id }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm" title="Hapus">
                                                <i class='bx bx-trash text-xl'></i>
                                            </button>
                                        </form>
                                    </div>
                                </x-table.td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table.index>
            @else
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-center py-16">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i class='bx bx-purchase-tag-alt text-4xl'></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Belum ada kategori</h3>
                    <p class="text-slate-500 text-sm">Silakan tambahkan kategori pelanggaran baru.</p>
                </div>
            @endif
    </div>
</x-layouts.app>