<div class="mt-0 py-3 px-3 border-b-2 border-b-indigo-100 navi-bar fixed inset-x-0 z-20 bg-[#f7f5ff]">
    <div class="max-w-7xl mx-auto align-center flex justify-between">
        <div class="flex items-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset(opt('site_logo')) }}" alt="logo" class="h-8 mr-2" />
            </a>
            <a href="{{ route('home') }}"
                class="text-xl lg:text-2xl font-black text-indigo-900 hover:text-indigo-700 uppercase hidden sm:block">
                {{ opt('site_title')  }}
            </a>
        </div>
        <div class="flex space-x-5 items-center">
            @guest
                <a class="hidden lg:block font-bold text-indigo-800 hover:text-indigo-600 text-lg"
                    href="/">@lang('navigation.home')</a>
            @endguest
            @auth
                <a class="font-bold text-indigo-800 hover:text-indigo-600 text-2xl lg:text-xl" href="{{ route('feed') }}">
                    <i class="fa-solid fa-house-signal"></i>
                </a>
                <a class="relative inline-flex font-bold text-indigo-800 hover:text-indigo-600 text-2xl lg:text-xl" href="{{ route('notifications.index') }}">
                    <span class="absolute -top-2 -right-2 py-0.5 px-1 rounded-full bg-rose-600 flex justify-center items-center items"><span class="text-xs text-white">{{ auth()->user()->unreadNotifications()->count() }}</span></span>
                    <i class="fa-solid fa-bell"></i>
                </a>
                <a class="font-bold text-indigo-800 hover:text-indigo-600 text-2xl lg:text-xl"
                    href="{{ route('browseCreators') }}">
                    <i class="fa-solid fa-compass"></i>
                </a>
            @endauth
            @guest
                <a class="hidden lg:block font-bold text-indigo-800 hover:text-indigo-600 text-lg"
                    href="{{ route('browseCreators') }}">@lang('navigation.exploreCreators')</a>
                <a class="hidden lg:block font-bold text-indigo-800 hover:text-indigo-600 text-lg"
                    href="{{ route('home') }}#platinum">@lang('navigation.platinum')</a>
                <a class="hidden lg:block border-2 rounded-full border-indigo-800 hover:bg-gray-100 px-4 py-1 font-bold text-indigo-800 hover:text-indigo-600 hover:border-indigo-600 mr-2 text-lg"
                    href="{{ route('login') }}">@lang('navigation.login')</a>
                <a class="hidden lg:block border-2 rounded-full border-indigo-800 bg-indigo-800 hover:bg-indigo-600 hover:border-indigo-600 px-4 py-1 font-bold text-white text-lg"
                    href="{{ route('register') }}">@lang('navigation.signUp')</a>
            @endguest
            <a id="naviBurger"
                class="border-2 rounded-full border-indigo-800 hover:bg-gray-100 px-4 py-1 font-bold text-indigo-800 hover:text-indigo-600 hover:border-indigo-600 mr-2 text-lg"
                href="javascript:void(0);">
                <i class="fa-solid fa-bars"></i></span>
            </a>
        </div>
    </div>
</div>

<!-- drawer navigation elements -->
<x-drawer-navi />
