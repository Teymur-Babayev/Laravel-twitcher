@extends('admin.base')

@section('section_title')
    <strong>{{ __('Tips Received by Creators')  }}</strong>
@endsection

@section('section_body')

    <div class="my-5 bg-stone-200 text-stone-500 font-semibold border-2 border-stone-300 p-3 rounded">
        {{ __('Here you will find an overview of the tips received by the creators from their fans')  }}
    </div>

    @if (count($tips))
        <table class="table border-collapse w-full bg-white text-stone-600 dataTable">
            <thead>
                <tr>
                    <x-th>{{ __('ID')  }}</x-th>
                    <x-th>{{ __('Tipper')  }}</x-th>
                    <x-th>{{ __('Creator')  }}</x-th>
                    <x-th>{{ __('Tip Amount')  }}</x-th>
                    <x-th>{{ __('Date')  }}</x-th>
                    <x-th>{{ __('Delete')  }}</x-th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tips as $t)
                    @if (is_null($t->tipper) or is_null($t->tipped))
                    @else
                        <tr>
                            <x-td>
                                <x-slot name="field">{{ __('ID')  }}</x-slot>
                                {{ $t->id }}
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Tipper')  }}</x-slot>
                                {{ $t->tipper->name }}
                                <br>
                                <a href="/{{ $t->tipper->profile->username }}">
                                    {{ $t->tipper->profile->handle }}
                                </a>
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Creator')  }}</x-slot>
                                {{ $t->tipped->name }}
                                <br>
                                <a href="/{{ $t->tipped->profile->username }}">
                                    {{ $t->tipped->profile->handle }}
                                </a>
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Tip Amount')  }}</x-slot>
                                <span class="inline-flex px-2 py-1 bg-indigo-50 text-indigo-700 rounded-lg">
                                    {{ opt('payment-settings.currency_symbol') . $t->amount }}
                                </span>
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Date')  }}</x-slot>
                                {{ $t->created_at->format('jS F Y') }}
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Delete')  }}</x-slot>
                                <a href="/admin/tips?delete={{ $t->id }}"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this user tip?')  }}')"
                                    class="text-red-400 hover:underline">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </x-td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="bg-white p-3 rounded">{{ __('No tips given to any of the users')  }}</div>
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
    $('.dataTable').dataTable({ordering:false});
    </script>
@endpush
