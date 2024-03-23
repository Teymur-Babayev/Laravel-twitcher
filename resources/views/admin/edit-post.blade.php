@extends('admin.base')

@section('section_title')
    {{ __('Edit post by :handle', ['handle' => $post->user->profile->handle]) }}
    <br />
    <a href="/admin/moderation/Image">&raquo; {{ __('Back to Moderation')  }}</a>
@endsection

@section('section_body')
    <div class="max-w-md bg-white rounded-lg shadow-sm p-3 text-stone-600">
        <form method="POST" action="/admin/save-user-post/{{ $post->id }}" enctype="multipart/form-data">
            @csrf
            <x-label>{{ $post->user->profile->handle }} {{ __('posted on his wall')  }}</x-label>
            <x-textarea name="text_content" rows="7" class="w-full">{{ $post->text_content }}</x-textarea>

            <x-label class="mt-3">{{ __('Post Type')  }}</x-label>
            <x-select name="post_type">
                <option value="Free" @if ($post->lock_type == 'Free') selected @endif>{{ __('Available to everyone')  }}</option>
                <option value="Paid" @if ($post->lock_type == 'Paid') selected @endif>{{ __('Paid, only available to paid subscribers')  }}</option>
            </x-select>

            <x-label class="mt-3">{{ __('Attached media')  }}</x-label>

            @if ($post->media_type != 'None' && $post->media_content)
                <div class="my-3">
                    <a href="/admin/delete-post-media/{{ $post->id }}" class="text-red-400 hover:underline"
                        onclick="return confirm('{{ __('Are you sure you want to remove this post media attachment?')  }}')">
                        <i class="fa-solid fa-trash"></i> {{ __('Delete Post Media')  }}
                    </a>
                </div>
                @if ($post->media_type == 'Image')
                    <img src="{{ \Storage::disk($post->disk)->url($post->media_content) }}" alt=""
                        class="rounded-lg" />
                @elseif($post->media_type == 'Video')
                    <video class="aspect-video w-full rounded-tr-lg rounded-tl-lg" controls
                        @if (opt('enableMediaDownload', 'No') == 'No') controlsList="nodownload" @endif preload="metadata"
                        disablePictureInPicture>
                        @if ($post->disk == 'backblaze')
                            <source
                                src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' . $post->media_content }}#t=0.5"
                                type="video/mp4" />
                        @else
                            <source src="{{ \Storage::disk($post->disk)->url($post->video_url) }}#t=0.5" type="video/mp4" />
                        @endif
                        @lang('post.videoTag')
                    </video>
                @elseif($post->media_type == 'Audio')
                    <div class="pt-4 px-2">
                        <audio class="w-full" controls @if (opt('enableMediaDownload', 'No') == 'No') controlsList="nodownload" @endif>
                            @if ($post->disk == 'backblaze')
                                <source
                                    src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' . $post->media_content }}"
                                    type="audio/mp3">
                            @else
                                <source src="{{ \Storage::disk($post->disk)->url($post->audio_url) }}" type="audio/mp3">
                            @endif
                            @lang('post.audioTag')
                        </audio>
                    </div>
                @elseif($post->media_type == 'ZIP')
                    <a href="{{ route('downloadZip', ['post' => $post]) }}" target="_blank"
                        class="text-lg font-bold text-stone-600 hover:text-stone-500 px-3 mt-4 inline-block">
                        <img src="{{ asset('images/zip-icon.svg') }}" alt="zip icon" class="w-8 h-8" />
                        @lang('v16.zipDownload')
                    </a>
                @endif
            @else
                {{ __('No picture, video, zip or audio attached - it is text only post')  }}
            @endif

            <hr/>
            <x-button class="mt-5">{{ __('Update User Post')  }}</x-button>
        </form>
    </div>
@endsection
