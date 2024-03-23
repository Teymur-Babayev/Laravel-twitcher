@extends('admin.base')

@section('section_title')
{{ __('Adjust Token Balance of :handle', ['handle' => $user->username]) }}
<br />
@if($user->is_streamer === 'yes')
<a href="/admin/streamers" class="text-indigo-700 hover:underline font-semibold">&raquo; {{ __('Back to Streamers')
    }}</a>
@else
<a href="/admin/users" class="text-indigo-700 hover:underline font-semibold">&raquo; {{ __('Back to Users') }}</a>
@endif
@endsection

@section('section_body')
<div class="max-w-md bg-white rounded-lg shadow-sm p-3 text-stone-600">
    <form method="POST" action="/admin/save-token-balance/{{ $user->id }}">
        @csrf
        <x-label>{{ __("New :username token balance", ['username' => $user->username]) }}</x-label>

        <x-input id="balance" class="block mt-0 w-full" type="numeric" value="{{ $user->tokens }}" name="balance"
            required />

        <hr />
        <x-button class="mt-5">{{ __('Adjust Balance') }}</x-button>
    </form>
</div>
@endsection