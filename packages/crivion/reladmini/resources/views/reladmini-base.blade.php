<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('reladmini.title', 'Reladmini') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{asset('fonts/nunito/fonts.css')}}" />
        {{-- <link rel="stylesheet" type="text/css" href="{{asset('fonts/fontawesome/css/all.min.css')}}" /> --}}

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0">
            <x-translations />
            @inertia
            <div id="modal-root"></div>

            This is from reladmini-base.blade.php
        </div>
    </body>
</html>
