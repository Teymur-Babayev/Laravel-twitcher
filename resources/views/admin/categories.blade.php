@extends('admin.base')

@section('section_title')
<strong>{{ __('Streamer Categories') }}</strong>
@endsection

@section('section_body')

<form method="POST" action="{{ empty($catname) ? '/admin/add_category' : '/admin/update_category' }}">
    {{ csrf_field() }}
    <div class="flex items-center bg-white rounded p-3">

        @if (!empty($catname))
        <input type="hidden" name="catID" value="{{ $catID }}">
        @endif

        <div>
            <x-input type="text" name="catname" value="{{ $catname }}" placeholder="{{ __('Category Name')  }}" />
        </div>

        <div class="ml-3">
            <x-button>{{ __('Save') }}</x-button>
        </div>
    </div><!-- /.col-xs-12 col-md-6 -->
</form>

<hr class="my-3" />

@if ($categories)
<table class="table border-collapse w-full bg-white text-stone-600">
    <thead>
        <tr>
            <x-th>{{ __('ID') }}</x-th>
            <x-th>{{ __('Category') }}</x-th>
            <x-th>{{ __('Users') }}</x-th>
            <x-th>{{ __('Actions') }}</x-th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $c)
        <tr>
            <x-td>
                <x-slot name="field">{{ __('ID') }}</x-slot>
                {{ $c->id }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Category') }}</x-slot>
                {{ $c->category }}
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Users') }}</x-slot>
                <span class="inline-flex px-2 py-1 bg-indigo-200 text-indigo-700 rounded-lg">
                    {{ $c->users_count }}
                </span>
            </x-td>
            <x-td>
                <x-slot name="field">{{ __('Actions') }}</x-slot>
                <div class="btn-group">
                    <a class="inline-flex mr-2" href="/admin/categories?update={{ $c->id }}">
                        <i class="fa-solid fa-pencil text-teal-600"></i>
                    </a>
                    <a href="/admin/categories?remove={{ $c->id }}"
                        onclick="return confirm('{{ __('Are you sure you want to remove this category from database?')  }}');"
                        class="inline-flex">
                        <i class="fa-solid fa-trash text-red-400"></i>
                    </a>
                </div>
            </x-td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
{{ __('No categories in database.') }}
@endif

@endsection