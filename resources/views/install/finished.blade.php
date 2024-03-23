@extends('install.install-base')

@section('title', __("Installation Successful"))

@section('content')

<div class="my-5 p-3 rounded-lg bg-green-500 text-white font-semibold">
    {{ __("You may now login with the default admin user and update it's user/password") }}
</div>

<div class="my-5">
    <strong class="block font-semibold text-lg">
        Default Admin Username
    </strong>
    <span class="block mt-2">
        admin@example.org
    </span>

    <strong class="block font-semibold text-lg mt-5">
        Default Admin Password
    </strong>
    <span class="block mt-2">
        adminer
    </span>
</div>

<a class="mt-5 inline-block bg-green-500 text-white font-semibold p-3 rounded-lg" href={{ route('admin.login') }}>
    {{ __("Admin Panel >>") }}
</a>

@endsection