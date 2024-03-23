<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset(opt('favicon', 'favicon.png')) }}" sizes="128x128" />

    <title inertia>{{ opt('seo_title') }}</title>

    @if(request()->route() && request()->route()->getName() == 'home')
    <meta name="description" content="{{ opt('seo_desc')  }}" />
    <meta name="keywords" content="{{ opt('seo_keys')  }}" />
    @endif

    @if(request()->route() && request()->route()->getName() == 'channel')
    @php
    $streamUser = \App\Models\User::whereUsername(request()->user)->firstOrFail();
    @endphp
    <meta property="og:title" content="{{ __(" :channelName channel (:handle)", ['channelName'=> $streamUser->name,
    'handle' => '@' . $streamUser->username]) }}" />
    <meta property="og:url" content="{{ route('channel', ['user' => $streamUser->username]) }}" />
    <meta property="og:image" content="{{ $streamUser->cover_picture }}" />
    @endif

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/nunito/fonts.css') }}" />

    <script>
        window.PUSHER_KEY = '{{ env('PUSHER_APP_KEY') }}';
        window.PUSHER_CLUSTER = '{{ env('PUSHER_APP_CLUSTER') }}';
    </script>

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
    @inertiaHead

</head>

<body class="font-sans antialiased ">
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0">
        <x-Translations />
        @inertia
        <div id="modal-root"></div>
    </div>
</body>

</html>