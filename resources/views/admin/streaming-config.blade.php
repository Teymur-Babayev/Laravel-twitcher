@extends('admin.base')

@section('section_title')
<strong>{{ __('Live Streaming Configuration') }}</strong>
@endsection

@section('section_body')

@include('admin.configuration-navi')

<div class="my-5 bg-gray-200 text-gray-500 font-semibold border-2 border-gray-300 p-3 rounded">
    {{ __('In order for Live Streaming to work, as described in documentation you need an NGINX-RTMP Server') }}
    <br />
    If you followed the docs, the url should be in format <strong
        class="font-black">rtmp://your-site-url.tld/live</strong>
    <br /><br />
    You can get a cheap VPS from <a href="https://www.linode.com/lp/free-credit-100/" target="_blank"
        class="underline">Linode (Free $100
        credit)</a>, <a href="https://m.do.co/c/833110c66c2c" class="underline">DigitalOcean (Free $200 Credit)</a> or
    your preferred
    VPS/Dedicated hosting provider.
</div>

<div class="bg-white rounded p-3 text-stone-600">

    <form method="POST">
        @csrf

        <div class="mt-5 flex md:flex-row flex-col md:space-x-5 space-y-10 md:space-y-0">
            <div class="md:w-2/3 w-full">
                <dl>
                    <dt class="font-semibold text-stone-600">{{ __('RTMP URL') }}</dt>
                    <dd>
                        <x-input type="text" name="RTMP_URL" value="{{ env('RTMP_URL') }}" class="md:w-2/3 w-full" />
                    </dd>

                    <br>
                </dl>
            </div>

            <div class="md:w-2/3 w-full">
                <p class="mt-3 text-gray-600">
                    <strong class="font-bold block text-lg">
                        Your Nginx Publish URL:
                    </strong>
                    {{ route('streaming.validateKey') }}
                </p>
            </div>


        </div>

        <div class="flex w-full my-3">
            <x-button>{{ __('Save Settings') }}</x-button>
        </div>
    </form>


</div><!-- ./row -->
@endsection