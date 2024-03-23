@extends('admin.base')

@section('section_title')
<strong>{{ __('Token Sales') }}</strong>
@endsection

@section('section_body')


@if (count($sales))
<table class="table border-collapse w-full bg-white text-stone-600 dataTable">
    <thead>
        <tr>
            <x-th>{{ __('ID') }}</x-th>
            <x-th>{{ __('Name') }}</x-th>
            <x-th>{{ __('Username') }}</x-th>
            <x-th>{{ __('Tokens') }}</x-th>
            <x-th>{{ __('Amount') }}</x-th>
            <x-th>{{ __('Gateway') }}</x-th>
            <x-th>{{ __('Date') }}</x-th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $s)
        @if (is_null($s->user))
        @else
        <tr>
            <x-td>
                <x-slot name="field">{{ __('ID') }}</x-slot>
                {{ $s->id }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Name') }}</x-slot>
                {{ $s->user->name }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Username') }}</x-slot>
                {{ $s->user->username }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Tokens') }}</x-slot>
                <span class="inline-flex px-2 py-1 bg-indigo-50 text-indigo-700 rounded-lg">
                    {{ $s->tokens }}
                </span>
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Amount') }}</x-slot>

                <span class="px-2 py-0.5 bg-cyan-600 text-white rounded-lg">
                    {{ opt('payment-settings.currency_symbol') . $s->amount }}
                </span>
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Gateway') }}</x-slot>
                {{ $s->gateway }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Date') }}</x-slot>
                {{ $s->created_at->format('jS F Y') }}
            </x-td>

        </tr>
        @endif
        @endforeach
    </tbody>
</table>
@else
<div class="bg-white p-3 rounded">{{ __('No token packs sold') }}</div>
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


{{-- attention, dynamic because only needed on this page to save resources --}}
@push('adminExtraJS')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/datatables/datatables.min.js') }}"></script>
<script>
    $('.dataTable').dataTable({ordering:false});
</script>
@endpush