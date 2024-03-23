<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/nunito/fonts.css') }}" />

    <!-- Scripts -->
    @vite(['resources/js/app.jsx'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0">
        @yield('content', '')
    </div>
</body>

</html>