@extends('admin.base')

@section('section_title')
<strong>{{ __('Cloud Storage Settings') }}</strong>
@endsection

@section('section_body')
<div class="p-3 rounded bg-white">
    <form method="POST" action="/admin/save-cloud-settings">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-xs-12 col-md-4">
                <dt class="text-stone-600 font-semibold text-lg">{{ __('Which storage to use as default?') }}</dt>
                <dd class="mt-2">
                    <x-select name="FILESYSTEM_DISK" class="w-full md:w-1/2">
                        <option value="public" @if (env('FILESYSTEM_DISK', 'public' )=='public' ) selected @endif>{{
                            __('Default: No cloud, just use my server') }}</option>
                        <option value="wasabi" @if (env('FILESYSTEM_DISK', 'public' )=='wasabi' ) selected @endif>{{
                            __('Wasabi S3 Storage (Better Cost than AWS)') }}</option>
                        <option value="s3" @if (env('FILESYSTEM_DISK', 'public' )=='s3' ) selected @endif>{{ __('Amazon
                            AWS S3 (Traditional Option)') }}</option>
                    </x-select>
                </dd>
                <br>
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:space-x-10">

            <div class="md:w-1/2">
                <h4 class="text-stone-600 font-semibold text-lg">{{ __('Wasabi Settings') }}</h4>
                <a href="https://wasabi.com/cloud-storage-pricing/"
                    target="_blank">https://wasabi.com/cloud-storage-pricing/</a>
                <hr>
                <dl class="mt-3">
                    <dt>{{ __('WAS Access Key') }}</dt>
                    <dd>
                        <x-input type="text" name="WAS_ACCESS_KEY_ID" value="{{ env('WAS_ACCESS_KEY_ID') }}"
                            class="lg:w-2/3 w-full" placeholder="" />
                    </dd>
                    <br>
                    <dt>{{ __('WAS Secret Key') }}</dt>
                    <dd>
                        <x-input type="text" name="WAS_SECRET_ACCESS_KEY" value="{{ env('WAS_SECRET_ACCESS_KEY') }}"
                            class="lg:w-2/3 w-full" placeholder="" />
                    </dd>
                    <br>
                    <dt>{{ __('WAS Region (example: eu-central-1)') }}</dt>
                    <dd>
                        <x-input type="text" name="WAS_DEFAULT_REGION" value="{{ env('WAS_DEFAULT_REGION') }}"
                            class="lg:w-2/3 w-full" placeholder="" />
                    </dd>
                    <br>
                    <dt>{{ __('WAS Bucket Name') }}</dt>
                    <dd>
                        <x-input type="text" name="WAS_BUCKET" value="{{ env('WAS_BUCKET') }}" class="lg:w-2/3 w-full"
                            placeholder="" />
                    </dd>
                    <br>
                    <dd>
                        <x-button>{{ __('Save Wasabi Settings') }}</x-button>
                    </dd>
                </dl>
            </div><!-- ./wasabi -->

            <div class="w-full md:w-1/2 mt-10 md:mt-0">
                <h4 class="text-stone-600 font-semibold text-lg">{{ __('Amazon AWS S3') }}</h4>
                <a href="https://aws.amazon.com/s3/" target="_blank">https://aws.amazon.com/s3/</a>
                <hr>
                <dl class="mt-3">
                    <dt>{{ __('AWS Access Key') }}</dt>
                    <dd>
                        <x-input type="text" name="AWS_ACCESS_KEY_ID" value="{{ env('AWS_ACCESS_KEY_ID') }}"
                            class="lg:w-2/3 w-full" placeholder="" />
                    </dd>
                    <br>
                    <dt>{{ __('AWS Secret Key') }}</dt>
                    <dd>
                        <x-input type="text" name="AWS_SECRET_ACCESS_KEY" value="{{ env('AWS_SECRET_ACCESS_KEY') }}"
                            class="lg:w-2/3 w-full" placeholder="" />
                    </dd>
                    <br>
                    <dt>{{ __('AWS Region (example: us-east-2, etc)') }}</dt>
                    <dd>
                        <x-input type="text" name="AWS_DEFAULT_REGION" value="{{ env('AWS_DEFAULT_REGION') }}"
                            class="lg:w-2/3 w-full" placeholder="" />
                    </dd>
                    <br>
                    <dt>{{ __('AWS Bucket Name') }}</dt>
                    <dd>
                        <x-input type="text" name="AWS_BUCKET" value="{{ env('AWS_BUCKET') }}" class="lg:w-2/3 w-full"
                            placeholder="" />
                    </dd>
                    <br>
                    <dd>
                        <x-button>{{ __('Save AWS S3 Settings') }}</x-button>
                    </dd>
                </dl>
            </div><!-- ./AWS -->

        </div>

    </form>

</div><!-- ./row -->
@endsection