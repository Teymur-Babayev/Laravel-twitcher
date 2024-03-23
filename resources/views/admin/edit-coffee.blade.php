@extends('admin.base')

@section('section_title')
    <strong>{{ __('Edit Coffee given by :buyer to :seller', ['buyer' => $coffee->buyer->profile->handle, 'seller' => $coffee->seller->profile->handle]) }}</strong>
    <br/>
    <a href="/admin/coffees">&raquo; {{ __('Back to Creator Coffees')  }}</a>
@endsection

@section('section_body')
    <form method="POST" action="/admin/update-coffee/{{ $coffee->id }}">
        @csrf
        <div class="p-3 rounded bg-white text-stone-600">
            <h3 class="font-semibold text-lg">{{ __('You can update the message & visibility of a coffee.')  }}</h3>
            <div class="max-w-md mt-3">
                <x-textarea class="w-full" name="message" placeholder="{{__('Optional message')  }}">{{ $coffee->message  }}</x-textarea>
                <br />
                <x-select name="isPublic" class="w-full mt-3">
                    <option value="yes" @if($coffee->is_public == 'yes') selected @endif>{{__('Public Message')   }}</option>
                    <option value="no" @if($coffee->is_public == 'no') selected @endif>{{ __('Private Message, only :handle can see', ['handle' =>  $coffee->seller->profile->handle])  }}</option>
                </x-select>
            </div>
            <x-button class="mt-5">{{ __('Edit Coffee')  }}</x-button>
        </div>
    </form>
@endsection
