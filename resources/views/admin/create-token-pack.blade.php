@extends('admin.base')

@section('section_title')
{{ __("Create Token Package")}}
<br />
<a href="/admin/token-packs" class="text-indigo-700 font-semibold hover:underline">&raquo; {{ __('Back to Packs') }}</a>
@endsection

@section('section_body')
<div class="max-w-md bg-white rounded-lg shadow-sm p-3 text-stone-600">
    <form method="POST" action="/admin/add-token-pack">
        @csrf
        <x-label>{{ __("Package Name")}}</x-label>

        <x-input id="name" class="block mt-0 w-full" type="text" value="" name="name" required />

        <x-label class="mt-3">{{ __("Tokens")}}</x-label>

        <x-input id="tokens" class="block mt-0 w-full" type="number" value="" name="tokens" required />

        <x-label class="mt-3">{{ __("Price") . " - " . opt('payment-settings.currency_symbol')}}</x-label>

        <x-input id="price" class="block mt-0 w-full" type="number" value="" name="price" required />

        <hr />
        <x-button class="mt-5">{{ __('Save Pack') }}</x-button>
    </form>
</div>
@endsection