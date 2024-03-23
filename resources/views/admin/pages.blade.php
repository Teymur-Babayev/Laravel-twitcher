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
    <strong>{{ __('Pages Manager')  }}</strong>
@endsection

@section('section_body')
    <table class="table border-collapse w-full bg-white text-stone-600 dataTable">
        <thead>
            <tr>
                <x-th>{{ __('ID')  }}</x-th>
                <x-th>{{ __('Title')  }}</x-th>
                <x-th>{{ __('Updated At')  }}</x-th>
                <x-th>{{ __('Actions')  }}</x-th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pages as $p)
                <tr>
                    <x-td>
                        <x-slot name="field">{{ __('ID')  }}</x-slot>
                        {{ $p->id }}
                    </x-td>
                    <x-td>
                        <x-slot name="field">{{ __('Title')  }}</x-slot>
                        <a href="{{ App\Models\Page::slug($p) }}" target="_blank">{{ $p->page_title }}</a>
                    </x-td>
                    <x-td>
                        <x-slot name="field">{{ __('Updated At')  }}</x-slot>
                        {{ $p->updated_at }}
                    </x-td>
                    <x-td>
                        <x-slot name="field">{{ __('Actions')  }}</x-slot>
                        <a href="/admin/cms-edit-{{ $p->id }}"><i
                                class="fa-solid fa-pencil mr-2 text-teal-600"></i></a>
                        <a href="/admin/cms-delete/{{ $p->id }}" onclick="return confirm('{{ __('Are you sure?')  }}')"><i
                                class="fa-solid fa-trash text-red-400"></i></a>
                    </x-td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('extra_bottom')
    @if (count($errors) > 0)
        <div class="bg-rose-500 text-white font-semibold p-3 rounded border-2 border-rose-200">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg p-3 shadow-sm">
        <div class="text-stone-600 font-semibold"><strong>{{ __('Create Page')  }}</strong></div>
        <div class="mt-2">
            <form method="POST">
                {{ csrf_field() }}
                <dl>
                    <dt>{{ __('Page Title')  }}</dt>
                    <dd>
                        <input type="text" name="page_title" class="w-full px-2 py-2 rounded-md shadow-sm border-2 outline-indigo-500 text-gray-700 font-bold border-gray-200" required="required"
                            value="{{ old('page_title') }}" />
                    </dd>
                    <br>
                    <dt>{{ __('Page Content')  }}</dt>
                    <dd>
                        <x-textarea name="page_content" class="w-full textarea" rows="20">
                            {{ old('page_content') }}
                        </x-textarea>
                    </dd>
                    <dt>&nbsp;</dt>
                    <dd>
                        <x-button>{{ __('Save')  }}</x-button>
                    </dd>
                </dl>
            </form>
        </div>
        <div class="box-footer"></div>
    </div>
@endsection