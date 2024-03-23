<div class="border-2 border-indigo-200 my-5 py-5 bg-white px-3 rounded-lg shadow-sm text-indigo-700">
    <p>{{ __('Your subscription allows adding :productsLimit products lifetime.', ['productsLimit' => opt('free_shop_limit')])  }}</p>
    <p>{{ __('Your have :remainingProducts products remaining.', ['remainingProducts' => auth()->user()->remainingProducts()])  }}</p>
    <a class="mt-3 inline-flex mr-2 rounded-full px-3 py-1 font-bold text-indigo-600 border-2 border-indigo-600 hover:text-indigo-800 hover:border-indigo-800 hover:bg-indigo-200" href="{{ route('home') }}#platinum">
        {{ __('Check Platinum') }}
    </a>
    {{ __(' for unlocking all limits')  }}
</div>