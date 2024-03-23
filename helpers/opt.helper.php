<?php

use App\Models\Options;
use App\Models\UserMeta;

if (!function_exists('opt')) {
    function opt($option_name, $default_value = null)
    {
        if ($option_name == 'home_callout_formatted') {
            $val = Options::get_option('home_callout', $default_value);
            $val = str_replace("##", "<b>", $val);
            $val = str_replace("$$", "</b>", $val);
            return $val;
        }

        return Options::get_option($option_name, $default_value);
    }
}

if (!function_exists('setopt')) {
    function setopt($option_name, $option_value)
    {
        return Options::update_option($option_name, $option_value);
    }
}


if (!function_exists('user_meta')) {
    function user_meta($key, $single = true, $user_id = 'self')
    {
        if ($user_id == 'self') {
            $user_id = auth()->id();
        }

        $userMeta = UserMeta::where('user_id', $user_id)->where('meta_key', $key);

        if ($single) {
            return $userMeta->pluck('meta_value')->first();
        } else {
            return $userMeta->get();
        }
    }
}

if (!function_exists('set_user_meta')) {
    function set_user_meta($key, $value, $replace = true, $user_id = 'self')
    {
        if ($user_id == 'self') {
            $user_id = auth()->id();
        }

        if ($replace) {
            $meta = UserMeta::firstOrCreate(
                ['user_id' => $user_id, 'meta_key' => $key],
                ['meta_value' => $value]
            );

            $meta->meta_value = $value;
            $meta->save();
        } else {
            $meta = new UserMeta();
            $meta->user_id = $user_id;
            $meta->meta_key = $key;
            $meta->meta_value = $value;
            $meta->save();
        }
    }
}



if (!function_exists('delopt')) {
    function delopt($option_name)
    {
        return Options::delete_option($option_name);
    }
}

if (!function_exists('turnLinksIntoAtags')) {
    // links in
    function turnLinksIntoAtags($string)
    {
        //The Regular Expression filter
        $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";

        // Check if there is a url in the text
        if (preg_match_all($reg_exUrl, $string, $url)) {
            // Loop through all matches
            foreach ($url[0] as $newLinks) {
                // if youtube/vimeo link
                if (stristr($newLinks, 'youtube.com') || stristr($newLinks, 'vimeo.com')) {
                    continue;
                }

                if (strstr($newLinks, ":") === false) {
                    $link = 'http://' . $newLinks;
                } else {
                    $link = $newLinks;
                }

                // Create Search and Replace strings
                $search  = $newLinks;
                $replace = '<a href="' . route('external-url', ['url' => $link]) . '" target="_blank" rel="nofollow">' . $link . '</a>';
                $string = str_replace($search, $replace, $string);
            }
        }

        // replace youtube links with embedded codes
        $string = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe class=\"w-full mt-2 mb-2\" height=\"450\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>", $string);

        // replace vimeo link with embedded codes
        $string = preg_replace('#https?://(www\.)?vimeo\.com/(\d+)#', '<div class="embed-container mt-2 mb-2"><iframe class="w-full mt-2 mb-2" height="450" src="//player.vimeo.com/video/$2" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe></div>', $string);

        return $string;
    }
}

function secure_image($image, $w, $h) {
    return Storage::disk('public')->url($image);
}