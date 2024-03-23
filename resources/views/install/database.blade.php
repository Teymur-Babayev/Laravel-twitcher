@extends('install.install-base')


@section('title', __("Database Configuration"))

@section('content')

<form method="POST" action={{ route('installer.saveDB') }}>
    @csrf
    <label class="text-gray-500 block mb-1 font-semibold">{{ __("Database Host") }}</label>
    <input type="text" class="border-2 p-2 block w-full rounded-lg" name="DB_HOST"
        value="{{ old('DB_HOST', 'localhost') }}" required />

    <label class="text-gray-500 block mt-3 font-semibold">{{ __("Database Name") }}</label>
    <input type="text" class="border-2 p-2 block w-full rounded-lg" name="DB_DATABASE" value="{{ old('DB_DATABASE') }}"
        required />

    <label class="text-gray-500 block mt-3 font-semibold">{{ __("Database User") }}</label>
    <input type="text" class="border-2 p-2 block w-full rounded-lg" name="DB_USERNAME" value="{{ old('DB_USERNAME') }}"
        required />

    <label class="text-gray-500 block mt-3 font-semibold">{{ __("Database Password") }}</label>
    <input type="text" class="border-2 mb-3 p-2 block w-full rounded-lg" name="DB_PASSWORD"
        value="{{ old('DB_PASSWORD') }}" />

    <button class="bg-rose-600 text-white font-semibold block p-3 rounded-lg" type="submit" name="sb">
        {{ __("Continue>>")}}
    </button>

</form>

@if ($errors->any())
<div class="my-5 p-3 rounded-lg bg-rose-600 text-white font-semibold">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session()->has('message'))
<div class="my-5 p-3 rounded-lg bg-rose-600 text-white font-semibold">
    {{ session('message') }}
</div>
@endif
@endsection