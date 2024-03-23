<div class="bg-white rounded p-3 my-5 text-gray-200">
    <a href="/admin/configuration"
        class="text-lg mr-2 text-indigo-600 hover:text-indigo-500 font-semibold @if(isset($active) && $active == 'configuration') border-b-indigo-600 font-bold border-b-2 @endif">
        {{ __('General') }}
    </a>
    |
    <a href="/admin/configuration/payment"
        class="text-lg mx-2 text-indigo-600 hover:text-indigo-500 font-semibold @if(isset($active) && $active == 'payments') underline @endif">
        {{ __('Payment Gateways') }}
    </a>
    |
    <a href="/admin/configuration/streaming"
        class="text-lg mx-2 text-indigo-600 hover:text-indigo-500 font-semibold @if(isset($active) && $active == 'streaming') underline @endif">
        {{ __('Live Streaming') }}
    </a>
    |
    <a href="/admin/configuration/chat"
        class="text-lg ml-2 text-indigo-600 hover:text-indigo-500 font-semibold @if(isset($active) && $active == 'chat') underline @endif">
        {{ __('Live Chat') }}
    </a>
</div>