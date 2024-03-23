<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Video;

class HomeController extends Controller
{
    // index
    public function index()
    {
        // get channel lists
        $channels = User::isStreamer()
                        ->with('categories')
                        ->withCount(['followers', 'subscribers', 'videos'])
                        ->orderByDesc('popularity')
                        ->take(6)
                        ->get();

        // get live now
        $livenow = User::isStreamer()
                        ->where('live_status', 'online')
                        ->with('categories')
                        ->withCount(['followers', 'subscribers', 'videos'])
                        ->orderByDesc('popularity')
                        ->take(6)
                        ->get();

        // latest videos
        $videos = Video::with(['category', 'streamer'])
                            ->latest()
                            ->take(6)
                            ->get();

        $meta_title = opt('seo_title');
        $meta_description = opt('seo_desc');
        $meta_keys = opt('seo_keys');
        $hide_live_channels = opt('hide_live_channels');

        return Inertia::render('Homepage', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'channels' => $channels,
            'livenow' => $livenow,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keys' => $meta_keys,
            'videos' => $videos,
            'hide_live_channels' => $hide_live_channels
        ]);
    }

    public function redirectToDashboard(Request $request)
    {
        $request->session()->flash('message', __('Welcome back, :name', ['name' => $request->user()->name]));

        if ($request->user()->is_streamer == 'yes') {
            return to_route('channel', ['user' => $request->user()->username]);
        } else {
            return to_route('home');
        }
    }
}
