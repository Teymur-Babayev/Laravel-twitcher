@extends('admin.base')

@section('section_title')
<strong>{{ __("Payout Requests") }}</strong>
@endsection

@section('section_body')

<div class="my-5 border-2 border-gray-300 bg-gray-200 p-3 rounded-lg shadow-sm text-gray-600 font-semibold">
    {{ __("When you mark a payment request as paid, you have to actually pay the user first manually to their bank
    account or
    paypal. This does NOT happen automatically.") }}
</div>


@if($payoutRequests->count())
<table class="text-stone-600 table border-collapse w-full bg-white dataTable">
    <thead>
        <tr>
            <x-th>{{ __('ID') }}</x-th>
            <x-th>{{ __('Streamer') }}</x-th>
            <x-th>{{ __('Tokens') }}</x-th>
            <x-th>{{ __('Money') }}</x-th>
            <x-th>{{ __('Payout Details') }}</x-th>
            <x-th>{{ __('Date') }}</x-th>
            <x-th>{{ __('--') }}</x-th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payoutRequests as $p)
        <tr>
            <x-td>
                <x-slot name="field">{{ __('ID') }}</x-slot>
                {{ $p->id }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Streamer') }}</x-slot>
                <div class="flex items-center w-full">
                    <div>
                        <img src="{{ $p->user->profile_picture }}" alt="" class="w-16 h-16 rounded-full" />
                    </div>
                    <div class="ml-2 text-left">
                        {{ $p->user->name }}<br />
                        {{ '@' . $p->user->username }}
                    </div>
                </div>

            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Tokens') }}</x-slot>
                <span class="px-2 py-0.5 bg-cyan-600 text-white rounded-lg">
                    {{ number_format($p->tokens, 0) }}
                </span>
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Money') }}</x-slot>
                <span class="px-2 py-0.5 bg-cyan-600 text-white rounded-lg">
                    {{ opt('payment-settings.currency_symbol') . $p->amount }}
                </span>
            </x-td>

            <x-td>
                <x-slot name="field">{{ __('Payout Details') }}</x-slot>
                @if($gm = $gateway_meta->where('user_id', $p->user_id)->first())
                {{ $gm->meta_value }}
                @else
                {{ __("User did not set a gateway") }}
                @endif
                <br />
                @if($gm = $payout_meta->where('user_id', $p->user_id)->first())
                {{ $gm->meta_value }}
                @else
                {{ __("User did not set payout details") }}
                @endif
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Date') }}</x-slot>
                {{ $p->created_at->format('jS F Y') }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('--') }}</x-slot>
                <a href="/admin/payout/mark-as-paid/{{ $p->id }}" class="text-teal-600 hover:underline"
                    onclick="return confirm('{{ __(" Are you sure you want to set this payment request as PAID?") }}')">
                    {{ __('Mark as Paid') }}
                </a>
            </x-td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
{{ __("No one requested a payout yet.") }}
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
{{-- attention, dynamic because only needed on this page to save resources --}}
<script>
    $(document).ready(function() {
        $('.dataTable').dataTable({ordering:false});
    });
</script>
@endpush