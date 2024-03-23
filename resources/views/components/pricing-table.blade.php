  <div class="py-2 px-2 mx-auto lg:py-10 lg:px-6">
      <div class="lg:flex items-center mb-8 lg:mb-12">
        <div class="lg:max-w-2xl w-full">
          <img src="{{ asset('images/indigo-likes.png') }}" alt="platinum" class="lg:max-w-2xl w-full mx-auto" />
        </div>
        <div>
          <p class="ml-10 mb-5 font-normal text-gray-500 sm:text-xl dark:text-gray-400 flex-grow text-justify">
              {{ __("Our platform is free to start and it provides every feature in a limited way so that you can get rolling.
              Once you grow - we have prepared a simple monthly & yearly plan for unlimited everything.")  }}
          </p>
          <p class="ml-10 mb-5 font-normal text-gray-500 sm:text-xl dark:text-gray-400 flex-grow text-justify">
            {{ __("We've made it simple and provided a hefty discount for the yearly plan. All the money goes back into the
              platform for operating, marketing and staff expenses.")  }}
          </p>
        </div>
      </div>
      <div class="lg:flex items-center lg:space-x-10 space-y-10 lg:space-y-0">
          <!-- Pricing Card -->
          <div
              class="flex flex-col p-6 mx-auto w-full text-center text-gray-900 bg-white rounded-lg border-2 border-indigo-300 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
              <h3 class="mb-4 text-2xl font-bold text-indigo-800 heading-gradient" id="platinum">
                  {{ __('GET STARTED FREE') }}</h3>
              <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">{{ __('Best to test our platform') }}
              </p>
              <div class="flex justify-center items-baseline my-8">
                  <span class="mr-2 text-5xl font-bold text-indigo-800 heading-gradient">{{ __('FREE') }}</span>
                  <span class="text-indigo-800 font-black">{{ __('/limits') }}</span>
              </div>
              <!-- List -->
              <ul role="list" class="mb-8 space-y-1 text-left">
                  <x-feature-item :isAlt="true">
                      {{ __('Up to :freePostsLimit Feed Posts', ['freePostsLimit' => opt('free_posts_limit')]) }}
                  </x-feature-item>
                  <x-feature-item>
                      {{ __('Up to :freeShopLimit Shop Products', ['freeShopLimit' => opt('free_shop_limit')]) }}
                  </x-feature-item>
                  <x-feature-item :isAlt="true">
                      {{ __('Max :freeCoffeesLimit Coffees/Tips', ['freeCoffeesLimit' => opt('free_tips_limit')]) }}
                  </x-feature-item>
                  <x-feature-item>
                      {{ __('Up to :paidSubscriberslimit Paid Subscribers', ['paidSubscriberslimit' => opt('free_subscribers_limit')]) }}
                  </x-feature-item>
                  <x-feature-item :isAlt="true" :isUnchecked="true">{{ __('ADS on your profile pages') }}
                  </x-feature-item>
                  <x-feature-item :isUnchecked="true">{{ __('NO Platinum Badge') }}</x-feature-item>
                  <x-feature-item :isAlt="true" :isUnchecked="true">{{ __('ADS shown on the platform') }}
                  </x-feature-item>
              </ul>
              <a class="w-full rounded-full px-5 py-2 font-bold text-indigo-600 border-2 border-indigo-600 hover:text-indigo-800 hover:border-indigo-800 hover:bg-indigo-200"
                  href="{{ route('register') }}">
                  {{ __('Start Free') }}
              </a>
          </div>
          <!-- Pricing Card -->
          <div
              class="flex flex-col p-6 mx-auto w-full text-center text-gray-900 bg-white rounded-lg border-2 border-indigo-300 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
              <h3 class="mb-4 text-2xl font-bold text-indigo-800 heading-gradient">{{ __('PLATINUM MONTHLY') }}</h3>
              <p class="font-light sm:text-lg text-indigo-800 heading gradient">{{ __('Unlimited Everything') }}</p>
              <div class="flex justify-center items-baseline my-8">
                  <span
                      class="mr-2 text-5xl font-bold text-indigo-800 heading-gradient">{{ opt('payment-settings.currency_symbol') . opt('saas.monthlyPrice') }}</span>
                  <span class="text-indigo-800 font-black">{{ __('/month') }}</span>
              </div>
              <ul role="list" class="mb-8 space-y-1 text-left">
                  <x-feature-item :isAlt="true">{{ __('Unlimited Posts') }}</x-feature-item>
                  <x-feature-item>{{ __('Unlimited Shop Products') }}</x-feature-item>
                  <x-feature-item :isAlt="true">{{ __('Unlimited Coffees/Tips') }}</x-feature-item>
                  <x-feature-item>{{ __('Unlimited Paid Subscribers') }}</x-feature-item>
                  <x-feature-item :isAlt="true">{{ __('No ADS on your profile page') }}</x-feature-item>
                  <x-feature-item>{{ __('Platinum Badge for authority') }}</x-feature-item>
                  <x-feature-item :isAlt="true">{{ __('No ADS while logged in') }}</x-feature-item>
              </ul>
              <a class="w-full rounded-full px-5 py-2 font-bold text-indigo-600 border-2 border-indigo-600 hover:text-indigo-800 hover:border-indigo-800 hover:bg-indigo-200"
                  href="{{ route('saas.subscribe', ['plan' => 'monthly']) }}">
                  {{ __('Get Platinum Monthly') }}
              </a>
          </div>
          <!-- Pricing Card -->
          <div
              class="flex flex-col p-6 mx-auto w-full text-center text-gray-900 bg-white rounded-lg border-2 border-indigo-300 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
              <h3 class="mb-4 text-2xl font-bold text-indigo-800 heading-gradient">{{ __('PLATINUM YEARLY') }}</h3>
              <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">{{ __('Fancy some discounts?') }}</p>
              <div class="flex justify-center items-baseline my-8">
                  <span
                      class="mr-2 text-5xl font-bold text-indigo-800 heading-gradient">{{ opt('payment-settings.currency_symbol') . opt('saas.yearlyPrice') }}</span>
                  <span class="text-indigo-800 font-black">{{ __('/year') }}</span>
              </div>
              <ul role="list" class="mb-8 space-y-1 text-left">
                  <x-feature-item :isAlt="true">{{ __('Unlimited Posts') }}</x-feature-item>
                  <x-feature-item>{{ __('Unlimited Shop Products') }}</x-feature-item>
                  <x-feature-item :isAlt="true">{{ __('Unlimited Coffees/Tips') }}</x-feature-item>
                  <x-feature-item>{{ __('Unlimited Paid Subscribers') }}</x-feature-item>
                  <x-feature-item :isAlt="true">{{ __('No ADS on your profile page') }}</x-feature-item>
                  <x-feature-item>{{ __('Platinum Badge for authority') }}</x-feature-item>
                  <x-feature-item :isAlt="true">{{ __('No ADS while logged in') }}</x-feature-item>
              </ul>
              <a class="w-full rounded-full px-5 py-2 font-bold text-indigo-600 border-2 border-indigo-600 hover:text-indigo-800 hover:border-indigo-800 hover:bg-indigo-200"
                  href="{{ route('saas.subscribe', ['plan' => 'yearly']) }}">
                  {{ __('Get Platinum Yearly') }}
              </a>
          </div>
      </div>
  </div>
