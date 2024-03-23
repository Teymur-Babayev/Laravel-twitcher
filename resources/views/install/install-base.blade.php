<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Twitcher Installer') }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css" />

    <!-- fontawesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/fontawesome/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/fontawesome/css/solid.min.css') }}" / </head>

<body class="bg-gray-200">

    <div class="mx-auto mt-10 w-96 border-2 p-5 rounded-lg bg-white shadow-sm">
        <img class="mx-auto h-14" src="{{ asset('images/twitcher-logo-dark.png') }}" alt="logo" />
        <h2 class="mt-3 mb-5 text-lg font-semibold text-center">
            @yield('title')
        </h2>

        @yield('content')

    </div>

</html>