<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class BrowseChannelsController extends Controller
{
    public function liveChannel()
    {
        $channel = User::isStreamer()
                        ->where('live_status', 'online')
                        ->with('categories')
                        ->withCount(['followers', 'subscribers', 'videos'])
                        ->inRandomOrder()
                        ->first();

        if ($channel) {
            return $channel->only(['id', 'username', 'name', 'profile_picture', 'headline',
                                    'followers_count', 'subscribers_count', 'videos_count',
                                'firstCategory', 'categories']);
        } else {
            return false;
        }
    }

    public function liveNow()
    {
        $channels = User::isStreamer()
                        ->where('live_status', 'online')
                        ->with('categories')
                        ->withCount(['followers', 'subscribers', 'videos'])
                        ->paginate(12);

        return Inertia::render('LiveNow', compact('channels'));
    }

    public function browse(Category $category = null, String $slug = null)
    {
        $request = request();

        $formCategories = $request->filled('selectedCategories') ? $request->selectedCategories : [];

        if (!$category) {
            $channels = User::isStreamer()->with('categories');
        } else {
            $channels = $category->users()->isStreamer()->with('categories');
        }

        $channels = $channels->withCount(['followers', 'subscribers','videos']);

        switch ($request->sort) {
            case 'Popularity':
            default:
                $channels = $channels->orderByDesc('popularity');
                break;

            case 'Followers':
                $channels = $channels->orderByDesc('followers_count');
                break;

            case 'Alphabetically':
                $channels = $channels->orderBy('name');
                break;

            case 'Recent':
                $channels = $channels->orderByDesc('created_at');
                break;

            case 'Subscribers':
                $channels = $channels->orderByDesc('subscribers_count');
                break;
        }

        // case search string
        if ($request->filled('search')) {
            $channels->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('username', 'LIKE', '%'.$request->search.'%');
            });
        }


        // case categories
        if ($request->filled('selectedCategories')) {
            $channels->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('category_user.category_id', $request->selectedCategories);
            });
        }

        $channels = $channels->paginate(12)->appends($request->query());

        $exploreImage = asset('images/explore.png');

        return Inertia::render('Channels', compact('channels', 'category', 'exploreImage'));
    }
}
