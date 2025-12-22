<nav x-data="{ scrolled: false, mobileOpen: false }"
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     class="fixed w-full z-50 top-0 transition-all duration-300 border-b border-transparent"
     :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm border-slate-200 py-3' : 'bg-white py-5 shadow-sm'">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14">

            <a href="{{ Auth::check() && Auth::user()->role === 'admin' ? '/dashboard' : '/home' }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200 group-hover:scale-110 transition">
                    <i class='bx bx-shield-exclamation text-2xl'></i>
                </div>
                <div class="leading-tight">
                    <div class="font-bold text-xl text-slate-800 tracking-tight group-hover:text-blue-600 transition">ANPUNDUNG</div>
                    <div class="text-[10px] font-bold text-blue-600 tracking-widest uppercase">Anti Pungli Bandung</div>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-1">
                @if (Illuminate\Support\Facades\Auth::check())
                    @php $user = Illuminate\Support\Facades\Auth::user() @endphp

                    @if ($user->role === 'admin')
                        <x-nav-link href="/dashboard" icon="bxs-dashboard" active="{{ request()->is('dashboard') }}">Dashboard</x-nav-link>
                        <x-nav-link href="/laporan" icon="bxs-file-pdf" active="{{ request()->is('laporan*') }}">Kelola Laporan</x-nav-link>
                        <x-nav-link href="/kategoris" icon="bx-tag" active="{{ request()->is('kategoris*') }}">Kategori</x-nav-link>
                    @else
                        <x-nav-link href="/home" icon="bxs-home" active="{{ request()->is('home') }}">Home</x-nav-link>
                        <x-nav-link href="/edukasi" icon="bxs-book" active="{{ request()->is('edukasi') }}">Edukasi</x-nav-link>
                        <x-nav-link href="/riwayat" icon="bxs-news" active="{{ request()->is('berita') }}">Riwayat</x-nav-link>
                        <x-nav-link href="/kontak" icon="bxs-message" active="{{ request()->is('kontak') }}">Kontak</x-nav-link>
                    @endif

                    <div class="ml-4 relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 pl-4 border-l border-slate-200 hover:opacity-80 transition">
                            <div class="text-right hidden lg:block">
                                <p class="text-xs font-bold text-slate-700">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold border-2 border-white shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>

                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 border border-slate-100 z-50 transform origin-top-right transition-all"
                             style="display: none;">
                            <a href="/profile" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition">
                                <i class='bx bx-user-circle'></i> Profile Saya
                            </a>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                    <i class='bx bx-log-out'></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login" class="text-sm font-bold text-slate-600 hover:text-blue-600 px-4 py-2 transition">Masuk</a>
                    <a href="/register" class="text-sm font-bold bg-blue-600 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition transform">Daftar Sekarang</a>
                @endif
            </div>

            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-2xl text-slate-600 p-2">
                <i class='bx' :class="mobileOpen ? 'bx-x' : 'bx-menu'"></i>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" class="md:hidden bg-white border-t border-slate-100 absolute w-full left-0 shadow-lg py-4 px-4 flex flex-col gap-2 z-40">
        @if (Illuminate\Support\Facades\Auth::check())
            @if (Illuminate\Support\Facades\Auth::user()->role === 'admin')
                <x-nav-link href="/dashboard" icon="bxs-dashboard" active="{{ request()->is('dashboard') }}">Dashboard</x-nav-link>
                <x-nav-link href="/laporan" icon="bxs-file-pdf" active="{{ request()->is('laporan*') }}">Kelola Laporan</x-nav-link>
                <x-nav-link href="/kategoris" icon="bx-tag" active="{{ request()->is('kategoris*') }}">Kategori</x-nav-link>
            @else
                <x-nav-link href="/home" icon="bxs-home" active="{{ request()->is('home') }}">Home</x-nav-link>
                <x-nav-link href="/edukasi" icon="bxs-book" active="{{ request()->is('edukasi') }}">Edukasi</x-nav-link>
                <x-nav-link href="/berita" icon="bxs-news" active="{{ request()->is('berita') }}">Berita</x-nav-link>
                <x-nav-link href="/kontak" icon="bxs-message" active="{{ request()->is('kontak') }}">Kontak</x-nav-link>
            @endif

            <div class="border-t border-slate-100 my-2 pt-2">
                <a href="/profile" class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg mb-2">
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div class="text-sm font-bold text-blue-900">{{ Auth::user()->name }}</div>
                </a>
                <form method="POST" action="/logout">
                    @csrf
                    <button class="w-full text-left p-3 text-red-600 font-bold bg-red-50 rounded-lg text-sm flex items-center gap-2">
                        <i class='bx bx-log-out'></i> Logout
                    </button>
                </form>
            </div>
        @else
            <a href="/login" class="block w-full text-center py-3 border border-slate-200 rounded-lg font-bold text-slate-600">Masuk</a>
            <a href="/register" class="block w-full text-center py-3 bg-blue-600 text-white rounded-lg font-bold">Daftar</a>
        @endif
    </div>
</nav>
