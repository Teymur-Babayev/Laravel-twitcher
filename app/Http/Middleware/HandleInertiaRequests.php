<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'unreadNotifications' => auth()->check() ? auth()->user()->unreadNotifications()->count() : null,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'logo_footer' => asset(opt('site_logo_footer')),
            'logo' => asset(opt('site_logo')),
            'site_title' => opt('site_title'),
            'seo_title' => opt('seo_title'),
            'currency_symbol' => opt('payment-settings.currency_symbol'),
            'currency_code' => opt('payment-settings.currency_code'),
            'token_value' => opt('token_value'),
            'min_withdraw' => opt('min_withdraw'),
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'categories' => Category::orderBy('category', 'ASC')->get(),
            'popular_channels' => User::isStreamer()
                                    ->with('categories')
                                    ->take(5)
                                    ->inRandomOrder()
                                    ->get(),
            'coins_sound' => asset('sounds/coins.mp3'),
            'pages' => Page::orderByDesc('page_title')->select(['id', 'page_title', 'page_slug'])->get(),
            'recaptcha_key' => opt('RECAPTCHA_KEY'),
            'anyone_live' => User::where('live_status', 'online')->exists(),
            'rtmp_url' => env('RTMP_URL'),
        ]);
    }
}
