<div class="md:flex md:flex-wrap border-b-2 border-b-indigo-100">
  <div class="lg:flex md:w-1/2 items-center py-10 px-5">
    <div class="mr-5 w-40 flex-shrink-0">
      <img src="{{asset('images/goals.svg')}}" alt="goals" class="w-full" />
    </div>
    <div>
      <h3 class="text-indigo-900 text-4xl font-extrabold mt-5 lg:mt-0">
        {{ __('ZERO Commissions') }}
      </h3>
      <h4 class="text-indigo-900 text-xl mt-5">
        {{ __('While other platforms take a commission your own money, we take')  }} 
        <span class="border-b-4 border-b-indigo-100 font-semibold">{{ __('0% from creators like you')  }}</span>
         {{ __('- every payment goes directly to you')  }}
      </h4>
    </div>
  </div><!-- ./lg:flex (zero commissions )-->
  <!--no-commissions-->
  <div class="lg:flex md:w-1/2 items-center py-10 px-5">
    <div class="mr-5 w-40 flex-shrink-0">
      <img src="{{asset('images/donations.svg')}}" alt="goals" class="w-full" />
    </div>
    <div>
      <h3 class="text-indigo-900 text-4xl font-extrabold mt-5 lg:mt-0">
        {{ __('Receive Donations')  }}
      </h3>
      <h4 class="text-indigo-900 text-xl mt-5">
        {{ __("Every creator has it's fans - the moment you get your first rewarding is an incredible appreciation sign for your hard work")  }}
      </h4>
    </div>
  </div><!-- ./lg-flex (donations) -->


  <div class="lg:flex md:w-1/2 items-center py-10 px-5">
    <div class="mr-5 md:w-40 flex-shrink-0 w-40">
      <img src="{{asset('images/memberships.svg')}}" alt="goals" class="w-full" />
    </div>
    <div>
      <h3 class="text-indigo-900 text-4xl font-extrabold mt-5 lg:mt-0">
        {{ __('Sell Memberships')  }}
      </h3>
      <h4 class="text-indigo-900 text-xl mt-5">
        {{ __('Sell monthly or yearly recurring memberships to people who want access to your exclusive content')  }}
      </h4>
    </div>
  </div><!-- ./lg:flex => memberships-->

  <div class="lg:flex md:w-1/2 items-center py-10 px-5">
    <div class="mr-5 w-40 flex-shrink-0">
      <img src="{{asset('images/products.svg')}}" alt="goals" class="w-full" />
    </div>
    <div>
      <h3 class="text-indigo-900 text-4xl font-extrabold">
        {{  __('Sell Products') }}
      </h3>
      <h4 class="text-indigo-900 text-xl mt-5">
        {{  __('Get your online Shop started in minutes - list your products and sell directly on our platform')  }}
      </h4>
    </div>
  </div><!-- ./lg:flex => sell-products -->
</div><!-- second row of info icons -->
