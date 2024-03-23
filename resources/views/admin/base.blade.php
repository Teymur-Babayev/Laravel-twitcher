<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>{{ __('Admin Panel') }}</title>

    <!-- fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/nunito/fonts.css') }}" />

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset(opt('favicon', 'favicon.png')) }}" sizes="128x128" />

    <!-- fontawesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/fontawesome/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/fontawesome/css/solid.min.css') }}" />

    <!-- datatables-->
    <link rel="stylesheet" type="text/css" href="{{ asset('js/datatables/datatables.min.css') }}" />

    <script>
        window.PUSHER_KEY = '{{ env('PUSHER_APP_KEY') }}';
        window.PUSHER_CLUSTER = '{{ env('PUSHER_APP_CLUSTER') }}';
    </script>

    <!-- Vite CSS -->
    @vite(['resources/js/app.jsx'])

    <!-- custom CSS from view files (if any) -->
    @stack('extraCSS')

    @stack('adminExtraCSS')

</head>

<body>


    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiase bg-gray-100 text-black">
        <div class="fixed w-full flex items-center justify-between h-14 text-white z-10 bg-zinc-900">
            <div class="bg-zinc-900 flex items-center w-full">
                <div>
                    <a href="{{route('home') }}" target="_blank">
                        <img src="{{ asset(opt('site_logo')) }}" alt="logo" class="h-8 ml-2" />
                    </a>
                </div>

            </div>
            <div class="flex w-full text-right justify-end items-center h-14 bg-zinc-900 header-right">
                <ul class="flex items-center">
                    <li>
                        <div class="block w-px h-6 mx-3 bg-zinc-900"></div>
                    </li>
                    <li>
                        <a class="flex items-center mr-4 hover:text-blue-100" href="{{ route('logout') }}" as="button">
                            <span class="inline-flex mr-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                </svg>
                            </span>
                            {{ __('Logout') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar -->
        @include('admin.admin-navi')
        <!-- ./Sidebar -->

        <!-- Page Content -->
        <div class="h-full ml-14 mt-14 mb-10 md:ml-64">
            <main>
                <div class="shadow-sm sm:rounded-lg bg-white w-full mx-auto p-4">
                    @yield('section_title', '')
                </div>

                @if (session('msg'))
                <div class="my-5 bg-blue-200 text-blue-700 font-semibold border-2 border-blue-300 p-3 rounded ml-3">
                    {{ session('msg') }}
                </div>
                @endif


                <div class="ml-3 mt-5">
                    @yield('extra_top', '')
                </div>

                <div class="ml-3 mt-5">
                    @yield('section_body', '')
                </div>


                <div class="ml-3 mt-5">
                    @yield('extra_bottom', '')
                </div>
            </main>
        </div>
    </div>



    @include('sweetalert::alert')

    @if ($errors->any())
    {{-- attention: this is required inline because it contains dynamic messages from session to output to the user --}}
    <script type="text/javascript">
        var errorList = '';
            @foreach ($errors->all() as $error)
                errorList += '{{ $error }}. ';
            @endforeach

            Swal.fire({
                title: '',
                icon: 'error',
                text: errorList
            });
    </script>
    @endif

    @stack('adminExtraJS')

</body>

</html>