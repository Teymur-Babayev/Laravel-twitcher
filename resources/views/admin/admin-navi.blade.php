<div class="
            fixed
            flex flex-col
            top-14
            left-0
            w-14
            hover:w-64
            md:w-64
            bg-zinc-800
            h-full
            text-white
            transition-all
            duration-300
            border-none
            z-10
            sidebar
        ">
    <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
        <ul class="flex flex-col py-4 space-y-1">
            <li class="px-5 hidden md:block">
                <div class="flex flex-row items-center h-8">
                    <div class="
                                text-sm
                                font-light
                                tracking-wide
                                text-gray-400
                                uppercase
                            ">
                        {{ __('TWITCHER :version', ['version' => TWITCHER_VERSION]) }}
                    </div>
                </div>
            </li>
            <li>
                <a class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6" href="/admin">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-dashboard"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{__("Dashboard")}}</span>
                </a>
            </li>
            <li>
                <a href="/admin/streamers" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-headset"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Streamers') }}</span></a>
            </li>
            <li>
                <a href="/admin/users" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Users') }}</span></a>
            </li>
            <li>
                <a href="/admin/token-sales" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-bank"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Token Sales') }}</span></a>
            </li>
            <li>
                <a href="/admin/token-packs" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-box-open"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Token Packages') }}</span></a>
            </li>
            <li>
                <a href="/admin/payout-requests" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-shop"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Payout Requests') }}</span></a>
            </li>
            <li>
                <a href="/admin/videos" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-film"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Videos') }}</span></a>
            </li>
            <li>
                <a href="/admin/subscriptions" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-user-check"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Subscriptions') }}</span></a>
            </li>
            <li>
                <a href="/admin/streamer-bans" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-ban"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Streamer Bans') }}</span></a>
            </li>
            <li>
                <a href="/admin/categories" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-tag"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Streamer Categories') }}</span></a>
            </li>
            <li>
                <a href="/admin/video-categories" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-tag"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Video Categories') }}</span></a>
            </li>
            <li>
                <a href="/admin/cms" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-bookmark"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Pages Manager') }}</span></a>
            </li>



            <li>
                <a href="/admin/configuration" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa pull-right hidden-xs showopacity fa-cog"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('App Configuration') }}</span></a>
            </li>

            <li>
                <a href="/admin/mailconfiguration" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-at"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Mail Server') }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/cloud" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-cloud"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Cloud Storage') }}</span></a>
            </li>
            <li>
                <a href="/admin/config-logins" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <i class="fa-solid fa-user-tag"></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Admin Logins') }}</span></a>
            </li>

        </ul>
        <p class="mb-14 px-5 py-3 hidden md:block text-center text-xs">
            <a href="{{ env('APP_URL') }}" target="_blank">{{ str_ireplace(['http://', 'https://'], ['', ''],
                env('APP_URL')) }}</a>
        </p>
    </div>
</div>
