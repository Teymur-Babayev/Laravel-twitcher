@php
$activeClass = 'hover:text-indigo-800 text-indigo-600 bg-white hover:bg-white';
$normalClass = 'text-indigo-800 hover:text-indigo-600 hover:bg-white';
@endphp
<ul class="space-y-2 max-w-xs">
    <li>
        <a href="{{ route('feed') }}"
            class="flex items-center p-2 text-base font-semibold rounded-lg  @if (isset($active) && $active == 'feed') {{ $activeClass }} @else {{ $normalClass }} @endif">
            <i class="fa-solid fa-house-signal"></i>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.feed')</span>
        </a>
    </li>
    <li>
        <a href="{{ route('browseCreators') }}"
            class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-white">
            <i class="fa-solid fa-compass"></i>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.exploreCreators')</span>
        </a>
    </li>
    <li>
        <a href="{{ route('profile.show', ['username' => auth()->user()->profile->username]) }}"
            class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-white">
            <i class="fa-solid fa-address-card"></i>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.myPage')</span>
        </a>
    </li>
    <li>
        <a href="{{ route('notifications.index') }}"
            class="relative flex items-center p-2 text-base font-semibold rounded-lg  @if (isset($active) && $active == 'notifications') {{ $activeClass }} @else {{ $normalClass }} @endif">
            <i class="fa-solid fa-bell"></i>
            <span class="ml-4 text-left whitespace-nowrap relative">
                @lang('navigation.myNotifications')
            </span>
            <span class="ml-2 bg-indigo-200 text-indigo-700 text-xs rounded-lg p-1">
                {{ __(':newNotifications new', ['newNotifications' => auth()->user()->unreadNotifications()->count()]) }}
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('messages.inbox') }}"
            class="relative flex items-center p-2 text-base font-semibold rounded-lg  @if (isset($active) && $active == 'messages') {{ $activeClass }} @else {{ $normalClass }} @endif">
            <i class="fa-solid fa-envelope"></i>
            <span class="ml-4 text-left whitespace-nowrap relative">
                @lang('navigation.messages')
            </span>
            <span class="ml-2 bg-indigo-200 text-indigo-700 text-xs rounded-lg p-1">
                {{ auth()->user()->unreadInboxCount() .' ' .__('new') }}
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('mySubscribers') }}"
            class="flex items-center p-2 text-base font-semibold rounded-lg  @if (isset($active) && $active == 'my-subscribers') {{ $activeClass }} @else {{ $normalClass }} @endif">
            <i class="fa-solid fa-user-shield"></i>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.my-subscribers')</span>
        </a>
    </li>
    <li>
        <a href="{{ route('mySubscriptions') }}"
            class="flex items-center p-2 text-base font-semibold rounded-lg @if (isset($active) && $active == 'my-subscriptions') {{ $activeClass }} @else {{ $normalClass }} @endif">
            <i class="fa-solid fa-user-tag"></i>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.my-subscriptions')</span>
        </a>
    </li>
    <li>
        <a href="{{ route('accountSettings') }}"
            class="relative flex items-center p-2 text-base font-semibold rounded-lg  @if (isset($active) && $active == 'settings') {{ $activeClass }} @else {{ $normalClass }} @endif">
            <i class="fa-solid fa-user-gear"></i>
            <span class="ml-3 text-left whitespace-nowrap relative">
                @lang('navigation.account')
            </span>
            <span class="ml-2 bg-indigo-200 text-indigo-700 text-xs rounded-lg p-1">
                @if(auth()->user()->isPlatinum())
                    @lang('navigation.accountTypePlatinum')
                @else
                    @lang('navigation.accountTypeFree')
                @endif
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('shop.myProducts') }}"
            class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-white">
            <i class="fa-solid fa-shop"></i>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">
                @lang('navigation.myShop')
                <i class="text-sm fa-solid fa-chevron-down"></i>
            </span>
        </a>
        <ul class="text-sm pl-10 @if (isset($active) && stristr($active, 'shop.')) @else hidden @endif">
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
            class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-white   @if (isset($active) && $active == 'shop.orders-placed') {{ $activeClass }} @else {{ $normalClass }} @endif">
            <i class="fa-solid fa-basket-shopping"></i>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.ordersPlaced')</span>
        </a>
    </li>
    <li>
        <a href="{{ route('paymentGateways') }}"
            class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-white  @if (isset($active) && $active == 'payment-gateways') {{ $activeClass }} @else {{ $normalClass }} @endif">
            <i class="fa-solid fa-cash-register"></i>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.paymentGateways')</span>
        </a>
    </li>
    <li>
        <a href="{{ route('logout') }}"
            class="flex items-center p-2 text-base font-semibold text-indigo-800 rounded-lg hover:text-indigo-600 hover:bg-white">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">@lang('navigation.logout')</span>
        </a>
    </li>
</ul>
