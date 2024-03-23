@extends('admin.base')

@section('section_title')
<strong>{{ __('General Configuration') }}</strong>
@endsection

@section('section_body')

@include('admin.configuration-navi')

<div class="bg-white rounded p-3 text-stone-600">
    <form method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mt-5 flex md:flex-row flex-col md:space-x-5 space-y-10 md:space-y-0">
            <div class="md:w-2/3 w-full">
                <dl>
                    <dt class="font-semibold text-stone-600">{{ __('SEO Title Tag') }}</dt>
                    <dd>
                        <x-input type="text" name="seo_title" value="{{ opt('seo_title') }}" class="md:w-2/3 w-full" />
                    </dd>
                    <br>
                    <dt class="font-semibold text-stone-600">{{ __('SEO Description Tag') }}</dt>
                    <dd>
                        <x-input type="text" name="seo_desc" value="{{ opt('seo_desc') }}" class="md:w-2/3 w-full" />
                    </dd>
                    <br>
                    <dt class="font-semibold text-stone-600">{{ __('SEO Keywords') }}</dt>
                    <dd>
                        <x-input type="text" name="seo_keys" value="{{ opt('seo_keys') }}" class="md:w-2/3 w-full" />
                    </dd>
                    <br>
                    <dt class="font-semibold text-stone-600">{{ __('Site Logo (Top Navi) (max 200x80px)') }}</dt>
                    <dd>
                        <x-input type="file" name="site_logo" class="md:w-2/3 w-full" />
                    </dd>

                    <br>
                    <dt class="font-semibold text-stone-600">{{ __('Site Favico') }} <strong>({{__('must be 128x128px')
                            }})</strong>
                    </dt>
                    <dd>
                        <x-input type="file" name="site_favico" class="md:w-2/3 w-full" />
                    </dd>

                    <label class="mt-5 font-semibold text-stone-600 block">{{ __('Require Streamers to Verify Identity
                        ?') }}</label>
                    <x-select name="streamersIdentityRequired" class="md:w-1/4 w-full">
                        <option value="Yes" @if(opt('streamersIdentityRequired', 'No' )=='Yes' ) selected @endif>
                            {{ __("Yes") }}
                        </option>
                        <option value="No" @if(opt('streamersIdentityRequired', 'No' )=='No' ) selected @endif>
                            {{ __("No") }}
                        </option>
                    </x-select>
                </dl>
            </div>


        </div>

        <div class="flex w-full my-3">
            <x-button>{{ __('Save Settings') }}</x-button>
        </div>
    </form>


</div><!-- ./row -->
@endsection