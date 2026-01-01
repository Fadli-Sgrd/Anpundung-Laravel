@props(['message' => 'Tidak ada data ditemukan', 'colspan' => 1])

<tr>
    <td colspan="{{ $colspan }}" class="p-12 text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
            <i class='bx bx-data text-4xl'></i>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $message }}</h3>
        <p class="text-slate-500 text-sm">Silakan tambahkan data baru.</p>
    </td>
</tr>
