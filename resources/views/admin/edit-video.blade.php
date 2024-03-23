@extends('admin.base')

@section('section_title')
{{ __('Edit Video') }}
<br />

<a href="/admin/videos" class="text-indigo-700 hover:underline font-semibold">&raquo; {{ __('Back To Videos') }}</a>
@endsection

@section('section_body')
<div class="max-w-lg bg-white rounded-lg shadow-sm p-3 text-stone-600">
    <form method="POST" action="/admin/videos/save/{{ $video->id }}">
        @csrf
        <x-label>{{ __("Title") }}</x-label>

        <x-input id="title" class="block mt-0 w-full" type="text" value="{{ $video->title }}" name="title" required />


        <x-label class="mt-5">{{ __("Category") }}</x-label>

        <x-select name="category_id" class="w-full">
            @foreach($video_categories as $c)
            <option value="{{ $c->id }}" @if($video->category_id == $c->id) selected @endif>{{ $c->category }}</option>
            @endforeach
        </x-select>

        <x-label class="mt-5">{{ __("Free for subscribers?") }}</x-label>

        <x-select name="free_for_subs" class="w-full">
            <option value="yes" @if($video->free_for_subs == "yes") selected @endif>{{ __("Yes") }}</option>
            <option value="no" @if($video->free_for_subs == "no") selected @endif>{{ __("No") }}</option>
        </x-select>

        <x-label class="mt-5">{{ __("Price") }}</x-label>

        <x-input id="price" class="block mt-0 w-full" type="text" value="{{ $video->price }}" name="price" required />

        <hr />
        <x-button class="mt-5">{{ __('Save') }}</x-button>
    </form>
</div>
@endsection