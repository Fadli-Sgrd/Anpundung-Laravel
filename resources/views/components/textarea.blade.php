@props(['disabled' => false, 'error' => null])

@php
    $baseClasses = 'w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200';
    $errorClasses = 'border-red-300 focus:border-red-500 focus:ring-red-500';
    $classes = $error ? "$baseClasses $errorClasses" : $baseClasses;
@endphp

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>{{ $slot }}</textarea>
