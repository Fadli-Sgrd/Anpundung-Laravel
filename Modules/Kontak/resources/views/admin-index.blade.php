<x-layouts.app title="Pesan Masuk">
    <div class="max-w-7xl mx-auto">

        {{-- ======================= --}}
        {{--       PAGE HEADER       --}}
        {{-- ======================= --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <a href="{{ route('dashboard') }}" 
                       class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-blue-600 hover:text-white transition duration-300">
                        <i class='bx bx-arrow-back text-lg'></i>
                    </a>
                    <h1 class="text-3xl font-extrabold text-slate-800">Pesan Masuk</h1>
                </div>
                <p class="text-slate-500 ml-11">Kelola kritik, saran, dan pertanyaan dari masyarakat.</p>
            </div>
            
            {{-- Breadcrumb simpel --}}
            <div class="hidden md:block">
                <span class="px-4 py-2 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-500 shadow-sm">
                    Dashboard <span class="mx-1 text-slate-300">/</span> <span class="text-blue-600">Feedback</span>
                </span>
            </div>
        </div>

        {{-- ======================= --}}
        {{--      FLASH MESSAGE      --}}
        {{-- ======================= --}}
        @if (session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        {{-- ======================= --}}
        {{--      STATS SECTION      --}}
        {{-- ======================= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <x-stat-card 
                variant="solid" 
                title="Total Pesan"
                value="{{ $feedback->count() }}"
                icon="bx bxs-inbox"
                color="blue"
                subtext="Pesan diterima sistem"
            />
            
            <div class="hidden md:block md:col-span-2"></div>
        </div>

        {{-- ======================= --}}
        {{--      MESSAGES LIST      --}}
        {{-- ======================= --}}
        @if ($feedback->isEmpty())
            <div class="bg-white rounded-[2rem] p-12 text-center border border-slate-100 shadow-sm flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-slate-50 text-slate-300 rounded-3xl flex items-center justify-center text-5xl mb-6">
                    <i class='bx bx-message-square-x'></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-2">Belum ada pesan masuk</h3>
                <p class="text-slate-500 max-w-md mx-auto">
                    Saat ini belum ada feedback atau pertanyaan yang dikirimkan melalui formulir kontak.
                </p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach ($feedback as $pesan)
                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition duration-300 group">
                        
                        {{-- Header Pesan --}}
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-5 pb-5 border-b border-slate-50">
                            <div class="flex items-start gap-4">
                                {{-- Avatar Inisial --}}
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 flex items-center justify-center font-bold text-lg shadow-sm border border-blue-100 shrink-0">
                                    {{ strtoupper(substr($pesan->nama, 0, 1)) }}
                                </div>
                                
                                <div>
                                    <h3 class="font-bold text-lg text-slate-800 group-hover:text-blue-600 transition">{{ $pesan->nama }}</h3>
                                    <div class="flex items-center gap-2 text-sm text-slate-500">
                                        <i class='bx bx-envelope'></i>
                                        <span>{{ $pesan->email }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
                                {{-- Tanggal Badge (Style Dashboard 'Verified') --}}
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-lg border border-slate-200 flex items-center gap-1">
                                    <i class='bx bx-calendar'></i>
                                    {{ $pesan->created_at->format('d M Y, H:i') }}
                                </span>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.pesan.destroy', $pesan->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-red-50 hover:text-red-500 transition border border-transparent hover:border-red-100"
                                        title="Hapus Pesan">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Konten Pesan --}}
                        <div class="pl-0 sm:pl-16">
                            <div class="mb-3">
                                <span class="inline-block text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded mb-2 uppercase tracking-wide">
                                    Subjek
                                </span>
                                <h4 class="font-bold text-slate-700">{{ $pesan->subject }}</h4>
                            </div>
                            
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $pesan->message }}</p>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-layouts.app>