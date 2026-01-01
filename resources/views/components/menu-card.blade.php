@props([
    'href',
    'icon',
    'title',
    'description',
    'color' => 'blue', // blue, purple, emerald, pink
    'badge' => null
])

@php
    $styles = [
        'blue' => [
            'icon_bg' => 'bg-blue-50',
            'icon_text' => 'text-blue-600',
            'hover_text' => 'group-hover:text-blue-600',
            'border_hover' => 'hover:border-blue-500 hover:ring-blue-500',
            'badge_bg' => 'bg-blue-100',
            'badge_text' => 'text-blue-600',
        ],
        'purple' => [
            'icon_bg' => 'bg-purple-50',
            'icon_text' => 'text-purple-600',
            'hover_text' => 'group-hover:text-purple-600',
            'border_hover' => 'hover:border-purple-500 hover:ring-purple-500',
            'badge_bg' => 'bg-purple-100',
            'badge_text' => 'text-purple-600',
        ],
        'emerald' => [
            'icon_bg' => 'bg-emerald-50',
            'icon_text' => 'text-emerald-600',
            'hover_text' => 'group-hover:text-emerald-600',
            'border_hover' => 'hover:border-emerald-500 hover:ring-emerald-500',
            'badge_bg' => 'bg-emerald-100',
            'badge_text' => 'text-emerald-600',
        ],
        'pink' => [
            'icon_bg' => 'bg-pink-50',
            'icon_text' => 'text-pink-600',
            'hover_text' => 'group-hover:text-pink-600',
            'border_hover' => 'hover:border-pink-500 hover:ring-pink-500',
            'badge_bg' => 'bg-pink-100',
            'badge_text' => 'text-pink-600',
        ],
    ];
    
    $c = $styles[$color] ?? $styles['blue'];
@endphp

<a href="{{ $href }}"
   class="group bg-white p-6 rounded-2xl border border-slate-200 {{ $c['border_hover'] }} hover:ring-1 transition cursor-pointer flex flex-col h-full">
    <div class="w-12 h-12 {{ $c['icon_bg'] }} {{ $c['icon_text'] }} rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
        <i class='{{ $icon }}'></i>
    </div>
    
    <h4 class="font-bold text-slate-800 mb-1 {{ $c['hover_text'] }} transition flex items-center gap-2">
        {{ $title }}
        @if($badge)
            <span class="px-2 py-0.5 {{ $c['badge_bg'] }} {{ $c['badge_text'] }} text-xs rounded-full">{{ $badge }}</span>
        @endif
    </h4>
    
    <p class="text-sm text-slate-500 leading-relaxed">{{ $description }}</p>
</a>
