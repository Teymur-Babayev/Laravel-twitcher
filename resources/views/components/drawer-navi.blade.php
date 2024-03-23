<div id="drawer-navigation"
    class="hidden fixed z-40 h-screen p-4 overflow-y-auto bg-white w-80 top-0 right-0 border-l-2 border-l-indigo-100">
    <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">
        @lang('navigation.navi')</h5>
    <button id="close-drawer-nav" type="button" data-drawer-dismiss="drawer-navigation" aria-controls="drawer-navigation"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-indigo-800 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </button>
    <div class="py-4 overflow-y-auto">
        <ul class="space-y-2">
            <li>
                <form method="POST" action="{{ route('search.results') }}">
                    @csrf
                    <div class="flex items-center space-x-2">
                        <input type="text" name="term" class="rounded border-2 py-1 px-1" placeholder="@lang('v103.search-placeholder')"/>
                        <button type="submit" class="rounded px-2 py-1 text-white bg-indigo-700">@lang('v103.Search')</button>
                    </div>
                </form>
            </li>
            <li>
                <a href="{{route('home')}}"
                    class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                    <i class="fa-solid fa-house"></i>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.home')</span>
                </a>
            </li>
            @auth
                <li>
                    <a href="{{ route('feed') }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-house-signal"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.feed')</span>
                    </a>
                </li>
            @endauth
            <li>
                <a href="{{ route('browseCreators') }}"
                    class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                    <i class="fa-solid fa-compass"></i>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.exploreCreators')</span>
                </a>
            </li>
            @auth
                <li>
                    <a href="{{ route('profile.show', ['username' => auth()->user()->profile->username]) }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-address-card"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.myPage')</span>
                    </a>
                </li>
            @endauth
            @guest
                <li>
                    <a href="{{ route('login') }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.login')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('register') }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-user-plus"></i>
                        <span class="flex-1 ml-2 text-left whitespace-nowrap">@lang('navigation.signUp')</span>
                    </a>
                </li>
            @endguest
            @auth
                <li>
                    <a href="{{ route('messages.inbox') }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-envelope"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.messages')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mySubscribers') }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-user-shield"></i>
                        <span class="flex-1 ml-2 text-left whitespace-nowrap">@lang('navigation.my-subscribers')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mySubscriptions') }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-user-tag"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.my-subscriptions')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('accountSettings') }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-user-gear"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.account')</span>
                    </a>
                </li>
                <li>
                    <a id="toggleDrawerNaviShop" href="javascript:void(0);"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-shop"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">
                            @lang('navigation.myShop')
                            <i class="text-sm fa-solid fa-chevron-down"></i>
                        </span>
                    </a>
                    <ul class="text-sm pl-10 hidden" id="drawerNaviShop">
                        <li>
                            <a href="{{ route('shop.addProduct') }}"
                                class="text-indigo-800 hover:text-indigo-600 @if (isset($active) && $active == 'shop.add-product') font-bold @endif">
                                {{ __('Add Product')  }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.myProducts') }}"
                                class="text-indigo-800 hover:text-indigo-600 @if (isset($active) && $active == 'shop.my-products') font-bold @endif">
                                {{ __('My Products')  }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.ordersReceived') }}"
                                class="text-indigo-800 hover:text-indigo-600 @if (isset($active) && $active == 'shop.orders-received') font-bold @endif">
                                {{ __('Orders Received')  }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.shippingSettings') }}"
                                class="text-indigo-800 hover:text-indigo-600 @if (isset($active) && $active == 'shop.shipping-settings') font-bold @endif">
                                {{ __('Shipping Settings')  }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.userShopFront', ['user' => auth()->user()->profile->username ]) }}"
                                    class="text-indigo-800 hover:text-indigo-600">
                                    {{ __('View Shopfront')  }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('shop.ordersPlaced')}}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.ordersPlaced')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('paymentGateways') }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-cash-register"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.paymentGateways')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                        class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-gray-100">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.logout')</span>
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</div>
