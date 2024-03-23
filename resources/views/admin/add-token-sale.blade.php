@extends('admin.base')

@section('section_title')
{{ __('Add Token Sale for :handle', ['handle' => $user->username]) }}
<br />
@endsection

@section('section_body')
<div class="max-w-md bg-white rounded-lg shadow-sm p-3 text-stone-600">
    <form method="POST" action="/admin/save-token-sale/{{ $user->id }}">
        @csrf
        <x-label>{{ __("Tokens to Add to User Balance", ['username' => $user->username]) }}</x-label>

        <x-input id="addTokens" class="block mt-0 w-full" type="numeric" value="{{ $pack->tokens }}" name="addTokens"
            required />

        <x-label class="mt-5">{{ __("Amount Paid in - :symbol", ['symbol' => opt('payment-settings.currency_symbol')])
            }}</x-label>

        <x-input id="amount" class="block mt-0 w-full" type="numeric" value="{{ $pack->price }}" name="amount"
            required />

        <hr />
        <x-button class="mt-5">{{ __('Add Token Sale') }}</x-button>
    </form>
</div>
@endsection