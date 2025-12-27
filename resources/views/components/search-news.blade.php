@props(['routeName' => 'news.index', 'placeholder' => 'Cari berita...', 'initialValue' => ''])

<div x-data="{ 
    search: '{{ $initialValue }}',
    timer: null,
    performSearch() {
        clearTimeout(this.timer);
        this.timer = setTimeout(() => {
            window.location.href = '{{ route($routeName) }}?search=' + encodeURIComponent(this.search);
        }, 500);
    },
    handleEnter() {
        window.location.href = '{{ route($routeName) }}?search=' + encodeURIComponent(this.search);
    }
}" class="relative group w-full max-w-md">
    <input 
        type="text" 
        x-model="search"
        @input="performSearch()"
        @keydown.enter="handleEnter()"
        placeholder="{{ $placeholder }}"
        class="block w-full px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all duration-300 font-bold shadow-sm group-hover:shadow-md"
    >

    <template x-if="search">
        <button 
            @click="search = ''; performSearch()"
            class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-300 hover:text-slate-500 transition-colors">
            <i class="bx bx-x-circle text-2xl"></i>
        </button>
    </template>
</div>
