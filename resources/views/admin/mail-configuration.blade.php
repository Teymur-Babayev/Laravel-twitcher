@extends('admin.base')

@section('section_title')
<strong>{{ __('Mail Configuration') }}</strong>
@endsection

@section('section_body')
<form method="POST">
    @csrf
    <div class="rounded p-3 bg-white">
        <dl>
            <dt class="font-semibold text-stone-600">{{ __('Mail Driver') }}</dt>
            <dd>
                <input type="radio" name="MAIL_MAILER" value="log" @if (env('MAIL_MAILER')=='log' ) checked @endif />
                {{ __('Log') }}
                <input type="radio" name="MAIL_MAILER" value="smtp" @if (env('MAIL_MAILER')=='smtp' ) checked @endif />
                {{ __('SMTP') }}
            </dd>
            <br>
            <dt class="font-semibold text-stone-600">{{ __('SMTP Mail Server') }}</dt>
            <dd>
                <x-input type="text" name="MAIL_HOST" value="{{ env('MAIL_HOST') }}" class="lg:w-2/3 w-full"
                    placeholder="smtp.example.com" />
            </dd>
            <dt class="font-semibold text-stone-600 mt-3">{{ __('SMTP Mail Port') }}</dt>
            <dd>
                <x-input type="number" name="MAIL_PORT" value="{{ env('MAIL_PORT') }}" class="lg:w-2/3 w-full"
                    placeholder="465" />
            </dd>
            <dt class="font-semibold text-stone-600 mt-3">{{ __('SMTP Mail Username') }}</dt>
            <dd>
                <x-input type="text" name="MAIL_USERNAME" value="{{ env('MAIL_USERNAME') }}" class="lg:w-2/3 w-full"
                    placeholder="you@example.com" />
            </dd>
            <dt class="font-semibold text-stone-600 mt-3">{{ __('SMTP Mail Password') }}</dt>
            <dd>
                <x-input type="password" name="MAIL_PASSWORD" value="{{ env('MAIL_PASSWORD') }}"
                    class="lg:w-2/3 w-full" />
            </dd>
            <dt class="font-semibold text-stone-600 mt-3">{{ __('SMTP Mail Encryption') }}</dt>
            <dd>
                <x-select class="lg:w-2/3 w-full" name="MAIL_ENCRYPTION">
                    <option value="null" @if (env('MAIL_ENCRYPTION')=='null' ) selected @endif>{{ __('None') }}</option>
                    <option value="ssl" @if (env('MAIL_ENCRYPTION')=='ssl' ) selected @endif>{{ __('SSL') }}</option>
                    <option value="tls" @if (env('MAIL_ENCRYPTION')=='tls' ) selected @endif>{{ __('TLS') }}</option>
                </x-select>
            </dd>
            <dt class="font-semibold text-stone-600 mt-3">{{ __('SMTP Mail From: (username@domain.com)') }}</dt>
            <dd>
                <x-input type="text" name="MAIL_FROM_ADDRESS" value="{{ env('MAIL_FROM_ADDRESS') }}"
                    class="lg:w-2/3 w-full" placeholder="you@example.com" />
            </dd>
            <dt class="font-semibold text-stone-600">&nbsp;</dt>
            <dd>
                <x-button>{{ __('Save Mail Settings') }}</x-button>
                <hr class="my-5" />
                <a href="/admin/mailtest" class="text-orange-600 hover:underline">{{ __('Send Test Email (use after
                    hitting Save first)') }}</a>
            </dd>
        </dl>
    </div><!-- ./row -->
    </div>
</form>
@endsection