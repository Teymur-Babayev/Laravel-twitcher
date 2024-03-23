@extends('install.install-base')

@section('title', __("Server Requirements Check"))

@section('content')
@foreach($requirements as $module => $result)

<div class="flex items-center justify-between">
    <p>
        {{ $module }}
    </p>
    <p>
        @if($result)
        <i class="fa-solid fa-check-circle text-green-600"></i>
        @else
        <i class="fa-solid fa-circle-xmark text-rose-600"></i>
        @endif
    </p>
</div>

@endforeach

@if($canContinue)
<a class="mt-5 inline-block bg-rose-600 text-white font-semibold p-3 rounded-lg" href="/install/database">
    {{ __("Continue >>") }}
</a>
@else
<div class="my-5 p-3 rounded-lg bg-rose-600 text-white font-semibold">
    {{ __("Please ask your host to enable the missing extensions to continue") }}
</div>
@endif
@endsection