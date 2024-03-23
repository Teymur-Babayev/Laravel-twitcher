@extends('admin.base')

@section('section_title')
<strong>{{ __('Live Chat Configuration') }}</strong>
@endsection

@section('section_body')

@include('admin.configuration-navi')

<div class="my-5 bg-gray-200 text-gray-500 font-semibold border-2 border-gray-300 p-3 rounded">
    {{ __('In order for Live Chat to work, as described in documentation you have to add') }}
    <a href="https://dashboard.pusher.com/apps" target="blank" class="text-indigo-600 hover:underline font-semibold">
        https://dashboard.pusher.com/apps
    </a>
    {{ __(' your Pusher App details.') }}
</div>

<div class="bg-white rounded p-3 text-stone-600">



    <form method="POST">
        @csrf

        <div class="mt-5 flex md:flex-row flex-col md:space-x-5 space-y-10 md:space-y-0">
            <div class="md:w-2/3 w-full">
                <dl>
                    <dt class="font-semibold text-stone-600">{{ __('Pusher APP_ID') }}</dt>
                    <dd>
                        <x-input type="text" name="PUSHER_APP_ID" value="{{ env('PUSHER_APP_ID') }}"
                            class="md:w-2/3 w-full" />
                    </dd>
                    <br>
                    <dt class="font-semibold text-stone-600">{{ __('Pusher APP_KEY') }}</dt>
                    <dd>
                        <x-input type="text" name="PUSHER_APP_KEY" value="{{ env('PUSHER_APP_KEY') }}"
                            class="md:w-2/3 w-full" />
                    </dd>
                    <br>
                    <dt class="font-semibold text-stone-600">{{ __('Pusher APP_SECRET') }}</dt>
                    <dd>
                        <x-input type="text" name="PUSHER_APP_SECRET" value="{{ env('PUSHER_APP_SECRET') }}"
                            class="md:w-2/3 w-full" />
                    </dd>

                    <br>
                    <dt class="font-semibold text-stone-600">{{ __('Pusher Region (Cluster)') }}</dt>
                    <dd>
                        <x-input type="text" name="PUSHER_APP_CLUSTER" value="{{ env('PUSHER_APP_CLUSTER') }}"
                            class="md:w-2/3 w-full" />
                    </dd>
                    <br>
                </dl>
            </div>


        </div>

        <div class="flex w-full my-3">
            <x-button>{{ __('Save Settings') }}</x-button>
        </div>
    </form>


</div><!-- ./row -->
@endsection