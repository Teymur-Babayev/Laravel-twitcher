@extends('admin.base')

@section('section_title')
    <strong>{{ __('Admin Login Configuration')  }}</strong>
@endsection

@section('section_body')
    <div class="bg-white p-3 rounded">
        <form method="POST" action="/admin/save-logins">
            {{ csrf_field() }}
            <dl>
                <dt class="text-stone-600 font-semibold">{{ __('Admin Login Email')  }}</dt>
                <dd>
                    <x-input type="text" name="admin_user" value="{{ auth()->user()->email }}" class="md:w-1/2 w-full" />
                </dd>
            </dl>
            <dl class="mt-3">
                <dt class="text-stone-600 font-semibold">{{ __('Admin New Password')  }}</dt>
                <dd>
                    <x-input type="password" name="admin_pass" value="" class="md:w-1/2 w-full" />
                </dd>
            </dl>
            <dl class="mt-3">
                <dt class="text-stone-600 font-semibold">{{ __('Admin Confirm New Password')  }}</dt>
                <dd>
                    <x-input type="password" name="admin_pass_confirmation" value="" class="md:w-1/2 w-full" />
                </dd>
            </dl>

            <x-button class="mt-4">{{ __('Save')  }}</x-button>
    </div>
@endsection
