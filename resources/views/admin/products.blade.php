@extends('admin.base')

@section('section_title')
    <strong>{{ __('Creator Products')  }}</strong>
@endsection

@section('section_body')
    @if (count($products))
        <table class="table border-collapse w-full bg-white text-stone-600 dataTable">
            <thead>
                <tr>
                    <x-th>{{ __('ID')  }}</x-th>
                    <x-th>{{ __('Thumbnail')  }}</x-th>
                    <x-th>{{ __('Product')  }}</x-th>
                    <x-th>{{ __('Creator')  }}</x-th>
                    <x-th>{{ __('Sales')  }}</x-th>
                    <x-th>{{ __('Stock')  }}</x-th>
                    <x-th>{{ __('Price')  }}</x-th>
                    <x-th>{{ __('Action')  }}</x-th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $t)
                    @if (is_null($t->user))
                    @else
                        <tr>
                            <x-td>
                                <x-slot name="field">{{ __('ID')  }}</x-slot>
                                {{ $t->id }}
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Thumbnail')  }}</x-slot>
                                <center>
                                <a href="{{ $t->slug }}">
                                    <img src="{{ asset($t->mainImage()) }}" alt="" class="rounded-lg w-32 mt-1" />
                                </a> 
                            </center>
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Product')  }}</x-slot>
                                <a href="{{ $t->slug}}" target="_blank">
                                    {{ $t->product_name }}
                                </a>
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Creator')  }}</x-slot>
                                <a href="/{{ $t->user->profile->username }}">
                                    {{ $t->user->profile->handle }}
                                </a>
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Sales')  }}</x-slot>
                                <span class="inline-flex px-2 py-1 bg-stone-200 text-stone-700 rounded-lg">
                                    {{ $t->sales }}
                                </span>
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Stock')  }}</x-slot>
                                <span class="inline-flex px-2 py-1 bg-teal-50 text-teal-700 rounded-lg">
                                    {{ $t->stock }}
                                </span>
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Price')  }}</x-slot>
                                <span class="inline-flex px-2 py-1 bg-indigo-50 text-indigo-700 rounded-lg">
                                    {{ opt('payment-settings.currency_symbol') . $t->price }}
                                </span>
                            </x-td>
                            <x-td>
                                <x-slot name="field">{{ __('Action')  }}</x-slot>
                                <a href="/admin/edit-product/{{$t->id}}">
                                    <i class="fa-solid fa-pencil mr-2 text-teal-600"></i>
                                </a>
                                <a href="/admin/delete-product/{{$t->id}}" class="text-red-400 /admin/edit-producthover:underline" onclick="return confirm('{{__('Are you sure you want to delete this product?')   }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </x-td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="bg-white p-3 rounded">{{ __('No products listed by any of the users.')  }}</div>
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
