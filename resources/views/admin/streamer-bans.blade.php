@extends('admin.base')

@section('section_title')
<strong>{{ __('Streamer Bans')  }}</strong>
@endsection

@section('section_body')

<div class="my-5 bg-stone-200 text-stone-500 font-semibold border-2 border-stone-300 p-3 rounded">
    {{ __('Here you will find an overview of the bans given to users by streamers.')  }}
</div>

@if (count($streamerBans))
<table class="table border-collapse w-full bg-white text-stone-600 dataTable">
    <thead>
        <tr>
            <x-th>{{ __('ID')  }}</x-th>
            <x-th>{{ __('Banned User')  }}</x-th>
            <x-th>{{ __('Streamer Live')  }}</x-th>
            <x-th>{{ __('IP')  }}</x-th>
            <x-th>{{ __('Date')  }}</x-th>
            <x-th>{{ __('Delete')  }}</x-th>
        </tr>
    </thead>
    <tbody>
        @foreach ($streamerBans as $t)
        @if (is_null($t->user) or is_null($t->streamer))
        @else
        <tr>
            <x-td>
                <x-slot name="field">{{ __('ID')  }}</x-slot>
                {{ $t->id }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('User')  }}</x-slot>
                {{ $t->user->name }}
                <br>
                {{ '@' . $t->user->username }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Streamer')  }}</x-slot>
                {{ $t->streamer->name }}
                <br>
                <a href="/channel/{{ $t->streamer->username }}" target="_blank">
                    {{ '@'.$t->streamer->username }}
                </a>
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Tip Amount')  }}</x-slot>
                {{$t->ip}}

            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Date')  }}</x-slot>
                {{ $t->created_at->format('jS F Y') }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Delete')  }}</x-slot>
                <a href="/admin/streamer-bans?delete={{ $t->id }}" onclick="return confirm('{{ __('Are you sure you want to lift this ban?')  }}')" class="text-red-400 hover:underline">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </x-td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
@else
<div class="bg-white p-3 rounded">{{ __('No bans given by streamers to users.')  }}</div>
@endif
@endsection

@section('extra_bottom')
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@endsection

@push('adminExtraJS')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/datatables/datatables.min.js') }}"></script>
{{-- attention, dynamic because only needed on this page to save resources  --}}
<script>
    $('.dataTable').dataTable({
        ordering: false
    });
</script>
@endpush
