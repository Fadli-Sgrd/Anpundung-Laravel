@props(['type' => 'success', 'message'])

@php
    $styles = [
        'success' => 'bg-emerald-50 border-emerald-100 text-emerald-700 icon-emerald-100',
        'error' => 'bg-red-50 border-red-100 text-red-700 icon-red-100',
        'warning' => 'bg-orange-50 border-orange-100 text-orange-700 icon-orange-100',
    ];
    $style = $styles[$type] ?? $styles['success'];
    
    $icons = [
        'success' => 'bx-check-circle',
        'error' => 'bx-x-circle',
        'warning' => 'bx-error',
    ];
    $icon = $icons[$type] ?? $icons['success'];
@endphp

<div {{ $attributes->merge(['class' => "{$style} border px-5 py-4 rounded-2xl mb-6 flex items-start gap-3 shadow-sm animate-fade-in-down"]) }}>
    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-white/50 backdrop-blur-sm">
        <i class='bx {{ $icon }} text-xl'></i>
    </div>
    <div>
        <p class="font-bold">{{ ucfirst($type) }}!</p>
        <p class="text-sm opacity-90">{{ $message }}</p>
    </div>
</div>
