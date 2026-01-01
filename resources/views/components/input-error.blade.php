@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1">
                <i class='bx bx-error-circle'></i> {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
