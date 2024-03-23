@extends('admin.base')

@section('section_title')
<strong>{{ __('Edit subscription of :subscriber to :streamer', ['subscriber' => $subscription->subscriber->username,
    'streamer' => $subscription->streamer->username]) }}</strong>
<br />
<a href="/admin/subscriptions">&raquo; {{ __('Back to Subscriptions') }}</a>
@endsection

@section('section_body')
<form method="POST" action="/admin/update-subscription/{{ $subscription->id }}">
    @csrf
    <div class="p-3 rounded bg-white text-stone-600">
        <h3 class="font-semibold text-lg">{{ __('You can update an user subscription towards a streamer if required') }}
        </h3>
        <div class="flex items-center space-x-2 mt-3">
            <div class="w-24">
                {{ __('Day') }}<br>
                <x-select class="w-full" name="dd">
                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" @if($i==$day) selected @endif>{{ $i }}
                        </option>
                        @endfor
                </x-select>
            </div>
            <div class="w-24">
                {{ __('Month') }}<br>
                <x-select class="w-full" name="mm">
                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" @if($i==$month) selected @endif>{{ $i }}
                        </option>
                        @endfor
                </x-select>
            </div>
            <div class="w-24">
                {{ __('Year') }}<br>
                <x-select class="w-full" name="yy">
                    @for ($i = date('Y'); $i <= date('Y') + 100; $i++) <option value="{{ $i }}" @if($i==$year) selected
                        @endif>{{ $i }}</option>
                        @endfor
                </x-select>
            </div>
        </div>
        <br />
        {{ __('Tokens Amount') }}<br />
        <x-input name="price" class="w-24" type="number" min="0" value="{{ $subscription->subscription_tokens }}"
            required />
        <br />
        <x-button class="mt-5">{{ __('Edit Subscription') }}</x-button>
    </div>
</form>
@endsection