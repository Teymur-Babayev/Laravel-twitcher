@extends('admin.base')

@section('section_title')
    <strong>{{ __('Edit Product')  }}</strong>
    <br/> 
    <a href="/admin/products">&raquo; {{ __('Back To products')  }}</a>
@endsection

@section('section_body')
<div class="p-3 rounded bg-white">

    <h3 class="text-stone-600 font-semibold text-lg mb-3">
        {{ __('You are editing a product owned by ')  }}
        <a href="{{ route('profile.show', ['username' => $product->user->profile->username]) }}">
            {{ $product->user->profile->handle  }}
        </a>
    </h3>

    <form method="POST" action="/admin/save-product/{{ $product->id }}" enctype="multipart/form-data">
    @csrf

    @if (isset($product))
        <input type="hidden" name="product_id" value="{{ $product->id }}" />
    @endif

    <x-label>{{ __('Product Name*') }}</x-label>
    <x-input type="text" name="product_name" class="w-full"
        value="{{ $product->product_name ?? old('product_name') }}" />
    <br><br>

    <div class="lg:flex lg:flex-row items-center">

        <div>
            <x-label>{{ __('Price*') }}<small class="pl-1 text-indigo-400 font-light">{{ __('without currency')  }}</small>
            </x-label>
            <x-input type="number" name="price" class="w-full" value="{{ $product->price ?? old('price') }}" />
        </div>

        <div class="mt-5 lg:mt-0 ml-0 lg:ml-5">
            <x-label>{{ __('Stock') }}<small class="pl-1 text-indigo-400 font-light">{{ __('optional')  }}</small></x-label>
            <x-input type="number" name="stock" class="w-full" step="1" min="0"
                value="{{ $product->stock ?? old('stock') }}" />
        </div>
    </div>
    <br><br>

    <x-label>{{ __('Product Description') }}<small class="pl-1 text-indigo-400 font-light">{{ __('optional')  }}</small>
    </x-label>
    <x-textarea name="description" class="w-full">{{ $product->description ?? old('description') }}</x-textarea>
    <br><br>

    <x-label>{{ __('Product Photos*') }}<small class="pl-1 text-indigo-400 font-light">{{ __('min 300x300px')  }}</small>
    </x-label>
    <div class="border-2 rounded p-2 border-indigo-200 bg-violet-50 mb-5">
       ADDING or UPDATING products has been disabled for the LIVE DEMO.
    </div>

    @if (auth()->user()->canAddProducts())
        <x-button id="sbManageProduct">
            {{ __('Save Product') }}
        </x-button>
    @elseif(!auth()->user()->canAddProducts() && request()->has('product_id'))
        <x-button id="sbManageProduct">
            {{ __('Save Product') }}
        </x-button>
    @endif
    </form>
</div>
@endsection

{{-- attention, this is dynamic and only needed on this page, uses laravel push/stack feature  --}}
@push('adminExtraJS')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/filepond/axios.min.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script>
        window.addEventListener("load", function() {
            
        const inputElement = document.querySelector("#filePond");

        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        const csrftoken = document.querySelector('meta[name="_token"]').content;

        const pond = FilePond.create(inputElement, {
            server: {
                process: {
                    url: "/file-upload/process",
                    method: "POST",
                    withCredentials: true,
                    headers: {
                        "X-CSRF-TOKEN": csrftoken,
                    },
                    onerror: (response) => {
                        const err = JSON.parse(response);
                        alert(err.message);
                    },
                },
                revert: {
                    url: "/file-upload/remove",
                    withCredentials: true,
                    headers: {
                        "X-CSRF-TOKEN": csrftoken,
                    },
                },
                load: "/file-upload/load/",
                restore: null,
                fetch: null,
                remove: (file, load) => {
                    axios
                        .delete("/file-upload/remove", {
                            headers: {
                                "Content-Type": "text/plain",
                                "X-CSRF-TOKEN": csrftoken,
                            },
                            data: file,
                        })
                        .then((result) => {
                            load();
                        })
                        .catch((err) => {
                            if (
                                err.response &&
                                err.response.data &&
                                err.response.data.message
                            ) {
                                alert(err.response.data.message);
                            } else {
                                alert(err.message);
                            }
                        });
                },
            },
            allowMultiple: true,
            allowBrowse: true,
            allowDrop: true,
            required: true,
            allowRemove: true,
            allowReorder: true,
            credits: false,
            autoProcess: true,
            acceptedFileTypes: ["image/png", "image/jpeg", "image/jpg"],
            imagePreviewHeight: 200,
        });

        @if (isset($product) && !is_null($product) && $product->images()->count())
            pond.setOptions({
                files: [
                    @foreach ($product->images as $image)
                        {
                            source: '{{ $image->id }}',
                            options: {
                                type: 'local',
                            },
                        },
                    @endforeach
                ]
            });
        @endif

    });

    // listen for events
    document.addEventListener('FilePond:addfilestart', (e) => {
        $("#sbManageProduct").attr('disabled', true);
        $("#sbManageProduct").hide();
    });

    document.addEventListener('FilePond:addfile', (e) => {
        $("#sbManageProduct").attr('disabled', false);
        $("#sbManageProduct").show();
    });

    document.addEventListener('FilePond:processfileprogress', (e) => {
        $("#sbManageProduct").attr('disabled', true);
        $("#sbManageProduct").hide();
    });

    document.addEventListener('FilePond:processfile', (e) => {
        $("#sbManageProduct").attr('disabled', false);
        $("#sbManageProduct").show();
    });
    </script>
@endpush
