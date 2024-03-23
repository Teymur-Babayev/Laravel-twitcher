@extends('admin.base')

@push('adminExtraJS')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '.textarea',
            plugins: 'image code link lists',
            images_upload_url: '/admin/cms/upload-image',
            toolbar: 'code | formatselect fontsizeselect | insertfile a11ycheck | numlist bullist | bold italic | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image tinydrive',
            promotion: false
        });
    </script>
@endpush

@section('section_title')
    <strong>{{ __('Pages Manager - Page Update')  }}</strong>
    <br />
    <a href="{{ route('admin-cms') }}">{{ __('Pages Overview')  }}</a>
@endsection

@section('section_body')
    <div class="bg-white rounded p-3">
        <form method="POST">
            {{ csrf_field() }}

            <dl>
                <dt>{{ __('Page Title')  }}</dt>
                <dd>
                    <input type="text" name="page_title" class="w-full px-2 py-2 rounded-md shadow-sm border-2 outline-indigo-500 text-gray-700 font-bold border-gray-200" value="{{ $p->page_title }}" />
                </dd>
                <br>
                <dt>{{ __('Page Content')  }}</dt>
                <dd>
                    <x-textarea name="page_content" class="w-full textarea" rows="20">{{ clean($p->page_content) }}</x-textarea>
                </dd>
                <dt>&nbsp;</dt>
                <dd>
                    <x-button>{{ __('Save')  }}</x-button>
                </dd>
            </dl>

        </form>
    </div>
@endsection
