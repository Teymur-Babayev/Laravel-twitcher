<div class="py-5 px-3 border-t-2 border-t-indigo-100 mt-[75px]">
  <div class="max-w-7xl mx-auto items-center lg:flex justify-between">
    <div class="flex items-center">
      <img src="{{ asset(opt('site_logo')) }}" alt="logo" class="h-8 mr-2" />
      <a href="{{route('home')  }}" class="text-2xl font-black text-indigo-900 hover:text-indigo-700 uppercase">
          {{ opt('site_title')  }}
      </a>
    </div>
    <div class="mt-5 lg:mt-0 flex flex-col lg:flex-row">
      @foreach($all_pages as $p)
      <a class="text-sm text-slate-500 hover:text-slate-700 mr-5" href="{{ route('page', ['page' => $p]) }}">{{ $p->page_title }}</a>
      @endforeach
      <a class="text-sm text-slate-500 hover:text-slate-700 mr-5" href="{{ route('report') }}">{{ __('Report Content') }}</a>
      <a class="text-sm text-slate-500 hover:text-slate-700 mr-5" href="{{ route('contact-page') }}">{{ __('Contact')  }}</a>
    </div>
  </div>
</div>
