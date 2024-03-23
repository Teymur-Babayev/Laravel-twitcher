@extends('admin.base')

@section('extra_top')
    <div class="bg-white rounded-lg p-3">
        <x-label class="text-stone-600">{{ __('Report form entries')  }}</x-label>
        @if(!count($reports)) 
            {{ __('No content reports from users.')  }}
        @endif
    </div>
    @if (count($reports))
            <div class="box-body">
                <table class="table border-collapse w-full bg-white text-stone-600">
                    <thead>
                        <tr>
                            <x-th>{{ __('Name')  }}</x-th>
                            <x-th>{{ __('Email')  }}</x-th>
                            <x-th>{{ __('URL')  }}</x-th>
                            <x-th>{{ __('Message')  }}</x-th>
                            <x-th>{{ __('IP')  }}</x-th>
                            <x-th>{{ __('Delete')  }}</x-th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $r)
                            <tr>
                                <x-td>
                                    <x-slot name="field">{{ __('Name')  }}</x-slot>
                                    {{ $r->reporter_name }}
                                </x-td>
                                <x-td>
                                    <x-slot name="field">{{ __('Email')  }}</x-slot>
                                    <a href="mailto:{{ $r->reporter_email }}">{{ $r->reporter_email }}</a>
                                </x-td>
                                <x-td>
                                    <x-slot name="field">{{ __('Reported URL')  }}</x-slot>
                                    <a href="{{ $r->reported_url }}" target="_blank">
                                        {{ $r->reported_url }}
                                    </a>
                                </x-td>
                                <x-td>
                                    <x-slot name="field">{{ __('Message')  }}</x-slot>
                                    {{ empty($r->report_message) ? '--' : $r->report_message }}
                                </x-td>
                                <x-td>
                                    <x-slot name="field">{{ __('IP')  }}</x-slot>
                                    {{ $r->reporter_ip }}
                                </x-td>
                                <x-td>
                                    <x-slot name="field">{{ __('Delete')  }}</x-slot>
                                    <a href="/admin/content-moderation/delete-report/{{ $r->id }}"
                                        class="text-rose-500 hover:underline" onclick="return confirm('{{ __('Delete report?')  }}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </x-td>
                            </tr>
                        @empty
                            {{ __('No content reports')  }}
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
        @endif
@endsection


@section('section_title')
    <strong>{{ __('Content Moderation')  }}</strong>
@endsection


@section('section_body')

    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500">
        <li>
            <a href="/admin/moderation/Image"
                class="inline-block p-4 rounded-t-lg hover:text-stone-600
                    hover:bg-white @if ($content_type == 'Image') bg-white @endif">
                {{ __('Images (:count)', ['count' => $counts['image']])  }}
            </a>
        </li>
        <li>
            <a href="/admin/moderation/Video"
                class="inline-block p-4 rounded-t-lg hover:text-stone-600
                    hover:bg-white @if ($content_type == 'Video') bg-white @endif">
                    {{ __('Videos (:count)', ['count' => $counts['video']])  }}
                </a>
        </li>
        <li>
            <a href="/admin/moderation/Audio"
                class="inline-block p-4 rounded-t-lg hover:text-stone-600
                    hover:bg-white @if ($content_type == 'Audio') bg-white @endif">
                    {{ __('Audios (:count)', ['count' => $counts['audio']])  }}    
                </a>
        </li>
        <li>
            <a href="/admin/moderation/ZIP"
                class="inline-block p-4 rounded-t-lg hover:text-stone-600
                    hover:bg-white @if ($content_type == 'ZIP') bg-white @endif">
                    {{ __('ZIP Files (:count)', ['count' => $counts['zip']])  }}
                </a>
        </li>
        <li>
            <a href="/admin/moderation/None"
                class="inline-block p-4 rounded-t-lg hover:text-stone-600
                    hover:bg-white @if ($content_type == 'None') bg-white @endif">
                    {{ __('Text Posts (:count)', ['count' => $counts['text']])  }}
                </a>
        </li>
    </ul>


    <div class="table-responsive">
        <table class="table border-collapse w-full bg-white text-stone-600 dataTable">
            <tr>
                <x-th>{{ __('ID')  }}</x-th>
                <x-th>{{ __('User')  }}</x-th>
                <x-th>{{ __('Type')  }}</x-th>
                <x-th>{{ __('Date')  }}</x-th>
                <x-th>{{ __('Text')  }}</x-th>
                <x-th>{{ __('Media')  }}</x-th>
                <x-th>{{ __('Actions')  }}</x-th>
            </tr>
            @forelse($contents as $p)
                <tr>
                    <x-td>
                        <x-slot name="field">{{ __('ID')  }}</x-slot>
                        {{ $p->id }}
                    </x-td>
                    <x-td>
                        <x-slot name="field">{{ __('User')  }}</x-slot>
                        <a href="{{ route('profile.show', ['username' => $p->profile->username]) }}" target="_blank">
                            {{ $p->profile->handle }}
                        </a>
                    </x-td>
                    <x-td>
                        <x-slot name="field">{{ __('Type')  }}</x-slot>
                        @if ($p->lock_type == 'Paid')
                            <span class="text text-danger">{{ __('Locked')  }}</span>
                        @else
                            <span class="text text-success">{{ __('Free')  }}</span>
                        @endif
                    </x-td>
                    <x-td>
                        <x-slot name="field">{{ __('Date')  }}</x-slot>
                        {{ $p->created_at->format('jS F Y') }}<br>
                        {{ $p->created_at->format('H:i a') }}
                    </x-td>
                    <x-td>
                        <x-slot name="field">{{ __('Content')  }}</x-slot>
                        <article class="max-h-52 overflow-scroll">
                            {!! clean($p->text_content) !!}
                        </article>
                    </x-td>
                    <x-td>
                        <x-slot name="field">{{ __('Media')  }}</x-slot>
                        @if ($p->media_type == 'Image')
                            @if ($p->disk == 'backblaze')
                                <a
                                    href="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' . $p->media_content }}">
                                    <img src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' . $p->media_content }}"
                                        alt="" class="img-responsive" width="200" />
                                </a>
                            @else
                                <a href="{{ \Storage::disk($p->disk)->url($p->media_content) }}" data-lightbox="lightbox {{$p->id  }}">
                                    <img src="{{ \Storage::disk($p->disk)->url($p->media_content) }}" alt=""
                                        class="img-responsive" width="200" />
                                </a>
                            @endif
                        @elseif($p->media_type == 'Video')
                            @if ($p->disk == 'backblaze')
                                <video width="420" height="340" controls controlsList="nodownload"
                                    disablePictureInPicture>
                                    <source
                                        src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' . $p->media_content }}"
                                        type="video/mp4" />
                                </video>
                            @else
                                <video width="420" height="340" controls controlsList="nodownload"
                                    disablePictureInPicture>
                                    <source src="{{ \Storage::disk($p->disk)->url($p->video_url) }}" type="video/mp4" />
                                </video>
                            @endif
                        @elseif($p->media_type == 'Audio')
                            @if ($p->disk == 'backblaze')
                                <audio class="w-100 mb-4" controls controlsList="nodownload">
                                    <source
                                        src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' . $p->media_content }}"
                                        type="audio/mp3" />
                                </audio>
                            @else
                                <audio class="w-100 mb-4" controls controlsList="nodownload">
                                    <source src="{{ \Storage::disk($p->disk)->url($p->audio_url) }}" type="audio/mp3">
                                </audio>
                            @endif
                        @elseif($p->media_type == 'ZIP')
                                <a href="{{ \Storage::disk($p->disk)->url($p->media_content) }}" data-toggle="lightbox">
                                    {{ __('Download ZIP')  }}
                                </a>
                        @else
                            {{ __('No media')  }}
                        @endif
                    </x-td>
                    <x-td>
                        <x-slot name="field">{{ __('Actions')  }}</x-slot>
                        <a href="/admin/edit-user-post/{{ $p->id }}"><i
                            class="fa-solid fa-pencil mr-2 text-teal-600"></i></a>
                        <a href="/admin/moderation/{{ $content_type }}?delete={{ $p->id }}"
                            class="text-red-400 hover:underline" onclick="return confirm('{{ __('Confirm delete?')  }}')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </x-td>
                </tr>
            @empty
                <div class="p-3 bg-white">
                    {{ __('There are no contents of type :contentType in database', ['contentType' => $content_type]) }}
                </div>
            @endforelse
    </div>
    </table>

    {{ $contents->links() }}

@endsection

{{-- only this page uses it, appended dynamically using push/stack laravel functions --}}
@push('adminExtraCSS')
    <link rel="stylesheet" type="text/css" href="{{asset('css/lightbox.min.css') }}" />
@endpush
@push('adminExtraJS')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.min.js') }}"></script>
@endpush