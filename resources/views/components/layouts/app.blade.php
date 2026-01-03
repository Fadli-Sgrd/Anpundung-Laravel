<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - ANPUNDUNG' : 'ANPUNDUNG' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-anpundung.png') }}">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen font-sans">

    <x-navbar />


    <main class="flex-grow pt-28 pb-12 px-4 sm:px-6 lg:px-8 w-full max-w-7xl mx-auto">
        {{ $slot }}
    </main>

    @if (
        !(request()->is('dashboard') ||
            request()->is('laporan*') ||
            request()->is('kategoris*') ||
            request()->is('profile*')
        ))
        <x-footer />
    @endif

    @stack('scripts')
</body>

</html>
