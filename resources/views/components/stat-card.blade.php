@props([
    'variant' => 'outline', // 'solid' or 'outline'
    'title',
    'value',
    'icon',
    'color' => 'blue', // primary color key
    'subtext' => null,
    'badge' => null
])

@php
    $baseClass = "rounded-2xl p-6 relative overflow-hidden transition duration-300";
    
    // Color Styles Configuration
    $styles = [
        'blue' => [
            'solid' => 'bg-gradient-to-br from-blue-600 to-slate-900 text-white shadow-lg shadow-blue-200',
            'outline_icon' => 'bg-blue-50 text-blue-600',
            'outline_badge' => 'bg-blue-100 text-blue-600',
            'subtext_solid' => 'text-blue-200',
        ],
        'orange' => [
            'solid' => 'bg-gradient-to-br from-orange-500 to-red-900 text-white shadow-lg shadow-orange-200',
            'outline_icon' => 'bg-orange-50 text-orange-500',
            'outline_badge' => 'bg-orange-100 text-orange-600',
            'subtext_solid' => 'text-orange-200',
        ],
        'emerald' => [
            'solid' => 'bg-gradient-to-br from-emerald-500 to-teal-900 text-white shadow-lg shadow-emerald-200',
            'outline_icon' => 'bg-emerald-50 text-emerald-500',
            'outline_badge' => 'bg-emerald-100 text-emerald-600',
            'subtext_solid' => 'text-emerald-200',
        ],
        'purple' => [
             'solid' => 'bg-gradient-to-br from-purple-500 to-indigo-900 text-white shadow-lg shadow-purple-200',
            'outline_icon' => 'bg-purple-50 text-purple-600',
            'outline_badge' => 'bg-purple-100 text-purple-600',
            'subtext_solid' => 'text-purple-200',
        ],
    ];

    $colorConfig = $styles[$color] ?? $styles['blue'];
    $variantClass = $variant === 'solid' ? $colorConfig['solid'] : 'bg-white border border-slate-100 shadow-sm hover:shadow-md text-slate-800';
@endphp

<div {{ $attributes->merge(['class' => "$baseClass $variantClass"]) }}>
    @if($variant === 'solid')
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
        
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <p class="text-white/80 text-sm font-bold uppercase tracking-wider">{{ $title }}</p>
                <i class='{{ $icon }} text-2xl text-white/80'></i>
            </div>
            <h2 class="text-4xl font-extrabold text-white">{{ $value }}</h2>
            @if($subtext)
                <p class="text-xs {{ $colorConfig['subtext_solid'] }} mt-2">{{ $subtext }}</p>
            @endif
        </div>
    @else
        {{-- Outline Variant --}}
        <div class="flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg {{ $colorConfig['outline_icon'] }} flex items-center justify-center text-xl">
                        <i class='{{ $icon }}'></i>
                    </div>
                    <p class="text-slate-500 text-sm font-bold">{{ $title }}</p>
                </div>
                @if($badge)
                    <span class="px-2 py-1 {{ $colorConfig['outline_badge'] }} text-xs font-bold rounded-md">{{ $badge }}</span>
                @endif
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800">{{ $value }}</h2>
        </div>
    @endif
</div>
