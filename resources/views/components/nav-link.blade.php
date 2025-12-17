@props(['active' => false, 'icon' => ''])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-2 px-4 py-2 text-sm font-bold text-blue-600 bg-blue-50 rounded-lg transition'
            : 'flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-500 hover:text-blue-600 hover:bg-slate-50 rounded-lg transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class='bx {{ $icon }} text-lg'></i>
    @endif
    {{ $slot }}
</a>