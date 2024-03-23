<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\Post;
use App\Models\Tips;
use App\Models\User;
use App\Models\Banned;
use App\Models\Report;
use App\Models\Options;
use App\Models\Profile;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\SaasSubscription;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\RoomBans;
use Illuminate\Support\Facades\Auth;
use App\Models\TokenPack;
use App\Models\TokenSale;
use App\Models\Video;
use App\Models\VideoCategories;
use App\Models\Withdrawal;
use App\Notifications\PaymentRequestProcessed;
use App\Notifications\StreamerVerifiedNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Admin extends Controller
{
    // update .env FILE
    public function __updateEnvKey($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('=' . env($key), '/');


        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }


    // GET|POST /admin/login
    public function login(Request $r)
    {
        $message = '';

        if ($r->isMethod('post')) {
            $credentials = [
                'email' => request('email'),
                'password' => request('password')
            ];


            if (Auth::attempt($credentials)) {
                // get current user info
                $user = auth()->user();


                if ($user->is_admin == 'yes') {
                    return redirect('admin');
                } else {
                    $message = 'Invalid admin login.';
                }
            } else {
                $message = 'Invalid login.';
            }
        }

        return view('admin.admin-login')->with('message', $message);
    }

    // streamer bans
    public function streamerBans(Request $r)
    {
        if ($r->filled('delete')) {
            $streamerBan = RoomBans::findOrFail($r->delete);

            if ($streamerBan) {
                $streamerBan->delete();
            }

            return redirect('/admin/streamer-bans')->with('msg', __('Ban successfully removed!'));
        }
        $streamerBans = RoomBans::with(['streamer', 'user'])->get();
        return view('admin.streamer-bans')->with('active', 'streamer-bans')->with('streamerBans', $streamerBans);
    }

    // GET /admin/logout
    public function logout()
    {
        \Session::forget('admin');
        auth()->logout();
        return redirect('/admin/login');
    }

    // GET /admin/config-logins
    public function configLogins()
    {
        return view('admin.config-logins')->with('active', 'admin-login');
    }

    // POST /admin/save-logins
    public function saveLogins(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $this->validate($r, [
            'admin_user' => 'required|email',
            'admin_pass' => 'required|confirmed'
        ]);

        $user = auth()->user()->id;
        $user = User::findOrFail($user);

        $user->email = $r->admin_user;
        $user->password = \Hash::make($r->admin_pass);
        $user->save();

        return back()->with('msg', 'Successfully updated admin user details.');
    }

    public function dashboard()
    {
        // get total streamers
        $allStreamers = User::where('is_streamer', 'yes')->count();

        // get total users
        $allUsers = User::where('is_streamer', 'no')->count();

        // get tokens sold total
        $tokensSold = TokenSale::where('status', 'paid')->sum('tokens');

        // get tokens amount total
        $tokensAmount = TokenSale::where('status', 'paid')->sum('amount');


        $date = \Carbon\Carbon::parse('31 days ago');
        $dateRange = \Carbon\CarbonPeriod::create($date, now());
        $earnings = [];

        foreach ($dateRange as $d) {
            $earnings[$d->format('Y-m-d')] = [
                'date' => $d->format('Y-m-d'),
                'tokens' => 0,
                'amount' => 0,
            ];
        }

        // compute token sales earnings
        $salesEarnings = TokenSale::select(array(
            DB::raw('DATE(`created_at`) as `date`'),
            DB::raw('SUM(`tokens`) as `tokensTotal`'),
            DB::raw('SUM(`amount`) as `amountTotal`')
        ))
            ->where('created_at', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        // append subscription earnings
        foreach ($salesEarnings as $d) {
            $earnings[$d->date]['date'] = $d->date;
            $earnings[$d->date]['tokens'] = $d->tokensTotal;
            $earnings[$d->date]['amount'] = $d->amountTotal;
        }


        // finally, return the view
        return view('admin.dashboard')
            ->with('active', 'dashboard')
            ->with('allStreamers', $allStreamers)
            ->with('allUsers', $allUsers)
            ->with('tokensAmount', $tokensAmount)
            ->with('tokensSold', $tokensSold)
            ->with('earnings', $earnings);
    }

    // verify streamer
    public function approveStreamer(Request $r)
    {
        $u = User::findOrFail($r->user);

        $u->is_streamer_verified = 'yes';
        $u->save();

        $u->notify(new StreamerVerifiedNotification());

        return redirect('/admin/streamers')->with('msg', __(":name (:username) was verified as a streamer", [
            'name' => $u->name,
            'username' => '@' . $u->username
        ]));
    }

    // payout requests
    public function payoutRequests()
    {
        $active = 'payout-requests';
        $payoutRequests = Withdrawal::where('status', 'Pending')->orderByDesc('id')->get();

        $gateway_meta = collect(DB::select('SELECT * FROM user_meta WHERE meta_key = ?', ['payout_destination']));
        $payout_meta = collect(DB::select('SELECT * FROM user_meta WHERE meta_key = ?', ['payout_details']));

        return view('admin.payout-requests', compact('payoutRequests', 'gateway_meta', 'payout_meta'));
    }

    // approve payment request
    public function markPaymentRequestAsPaid(Withdrawal $withdrawal)
    {
        // mark withdrawal as paid
        $withdrawal->status = 'Paid';
        $withdrawal->save();

        // subtract the balance
        $withdrawal->user->tokens -= $withdrawal->tokens;
        $withdrawal->user->save();

        // email the happy streamer
        $withdrawal->user->notify(new PaymentRequestProcessed($withdrawal));

        return back()->with('msg', __('Payment request marked as Paid and user notified!'));
    }

    // videos
    public function videos(Request $r)
    {
        if ($r->filled('remove')) {
            if (env('IS_LIVE_DEMO', false) === true) {
                return back()->with('msg', 'No changes will be applied on this live demo.');
            }

            $video = Video::findOrFail($r->remove);
            $video->sales()->delete();
            $video->delete();

            return back()->with('msg', __('Video successfully removed!'));
        }

        $active = 'videos';
        $videos = Video::orderByDesc('id');

        if ($r->filled('search')) {
            $videos->where('title', 'LIKE', '%' . $r->search . '%');
        }

        $videos = $videos->paginate(9);

        return view('admin.videos', compact('active', 'videos'));
    }

    // edit video
    public function editVideo(Video $video)
    {
        $active = 'videos';
        $video_categories = VideoCategories::orderBy('category')->get();
        return view('admin.edit-video', compact('active', 'video', 'video_categories'));
    }

    // update video
    public function saveVideo(Video $video, Request $request)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $request->validate(['title' => 'required', 'price' => 'required|numeric|min:0', 'free_for_subs' => 'required|in:yes,no', 'category_id' => 'required|exists:video_categories,id']);
        $video->update($request->only(['title', 'price', 'free_for_subs', 'category_id']));

        return redirect('admin/videos')->with('msg', __('Successfully updated video #' . $video->id));
    }

    // subscriptions
    public function subscriptions(Request $r)
    {
        if ($r->has('delete')) {
            // get subscription info
            $subscr = Subscription::findOrFail($r->delete);

            // delete
            $subscr->delete();

            return back()->with('msg', 'Subscription deleted.');
        }

        $active = 'subscriptions';
        $subscriptions = Subscription::with('streamer', 'subscriber')
            ->orderByDesc('id')
            ->whereDate('subscription_expires', '>=', Carbon::now())
            ->get();
        return view('admin.subscriptions', compact('subscriptions', 'active'));
    }


    // token sales
    public function tokenSales()
    {
        $active = 'token-sales';
        $sales = TokenSale::where('status', 'paid')->orderByDesc('id')->get();

        return view('admin.token-sales', compact('sales', 'active'));
    }

    public function addTokenSale(Request $request)
    {
        $request->validate(['user' => 'required|exists:users,id', 'packId' => 'required|exists:token_packs,id']);

        $user = User::find($request->user);
        $pack = TokenPack::find($request->packId);

        $active = 'token-sales';
        return view('admin.add-token-sale', compact('active', 'user', 'pack'));
    }

    public function saveTokenSale(User $user, Request $request)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $request->validate(['addTokens' => 'required|numeric|min:1', 'amount' => 'required|numeric']);

        $user->increment('tokens', $request->addTokens);

        TokenSale::create([
            'user_id' => $user->id,
            'tokens' => $request->addTokens,
            'amount' => $request->amount,
            'gateway' => 'Bank Transfer',
            'status' => 'paid'
        ]);

        return redirect('admin/token-sales')->with('msg', __(":tokensCount tokens were added to :username balance", ["tokensCount" => $request->addTokens, "username" => $user->username]));
    }

    // token packs
    public function tokenPacks(Request $r)
    {
        if ($r->filled('remove')) {
            if (env('IS_LIVE_DEMO', false) === true) {
                return back()->with('msg', 'No changes will be applied on this live demo.');
            }

            TokenPack::findOrFail($r->remove)->delete();
            return back()->with('msg', __('Token package removed.'));
        }

        $active = 'token-sales';
        $packs = TokenPack::orderBy('price')->get();

        return view('admin.token-packs', compact('packs', 'active'));
    }

    // create token pack
    public function createTokenPack()
    {
        return view('admin.create-token-pack');
    }

    // edit token pack
    public function editTokenPack(TokenPack $tokenPack)
    {
        return view('admin.edit-token-pack', compact('tokenPack'));
    }

    public function addTokenPack(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $r->validate([
            'name' => 'required',
            'tokens' => 'required|numeric|min:1',
            'price' => 'required|min:1'
        ]);

        TokenPack::create($r->only(['name', 'tokens', 'price']));

        return redirect('admin/token-packs')->with('msg', __('Token package was successfully created.'));
    }

    public function updateTokenPack(TokenPack $tokenPack, Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $r->validate([
            'name' => 'required',
            'tokens' => 'required|numeric|min:1',
            'price' => 'required|min:1'
        ]);

        $tokenPack->update($r->only(['name', 'tokens', 'price']));

        return redirect('admin/token-packs')->with('msg', __('Token package was successfully updated.'));
    }

    // tips
    public function tips(Request $r)
    {
        if ($r->has('delete')) {
            if (env('IS_LIVE_DEMO', false) === true) {
                return back()->with('msg', 'No changes will be applied on this live demo.');
            }

            $tip = Tips::findOrFail($r->delete);
            $tip->delete();

            return back()->with('msg', 'User tip successfully removed!');
        }

        $active = 'tips';
        $tips = Tips::with('tipper', 'tipped')
            ->orderByDesc('id')
            ->where('payment_status', 'Paid')
            ->get();


        return view('admin.tips', compact('tips', 'active'));
    }


    public function streamers(Request $r)
    {
        $active = 'streamers';


        if ($r->has('remove')) {
            if (env('IS_LIVE_DEMO', false) === true) {
                return back()->with('msg', 'No changes will be applied on this live demo.');
            }

            if ($r->remove == 1) {
                return back()->with('msg', 'Do not delete the main admin user');
            }

            // find user and delete all it's related data
            $user = User::findOrFail($r->remove);
            $user->delete();

            return back()->with('msg', 'Succesfully removed all this streamer & his data');
        }

        $users = User::where('is_streamer', 'yes')->orderByDesc('id')->get();


        return view('admin.users', compact('active', 'users'));
    }


    // edit creator subscription
    public function editSubscription(Subscription $subscription)
    {
        $planExpires = explode("-", $subscription->subscription_expires);
        list($year, $month, $day) = $planExpires;

        $day = explode(" ", $day);
        $day = reset($day);

        return view('admin.edit-subscription', compact('subscription', 'day', 'month', 'year'));
    }

    public function updateSubscription(Subscription $subscription, Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $this->validate($r, [
            'mm'      => 'required|numeric',
            'dd'      => 'required|numeric',
            'yy'      => 'required|numeric',
            'price' => 'required|numeric|min:0',
        ]);

        // compute plan expires
        $planExpires = mktime(0, 0, 0, $r->mm, $r->dd, $r->yy);

        $subscription->subscription_expires = date('Y-m-d H:i:s', $planExpires);
        $subscription->subscription_tokens = $r->price;
        $subscription->save();

        return redirect('admin/subscriptions')->with('msg', $subscription->subscriber->username . ' subscription to @' . $subscription->streamer->username . ' successfully updated');
    }

    // users overview
    public function users(Request $r)
    {
        $active = 'users';

        if ($r->has('remove')) {
            if (env('IS_LIVE_DEMO', false) === true) {
                return back()->with('msg', 'No changes will be applied on this live demo.');
            }

            if ($r->remove == 1) {
                return back()->with('msg', 'Do not delete the main admin user');
            }

            // find user and delete all it's related data
            $user = User::findOrFail($r->remove);
            $user->delete();

            return back()->with('msg', 'Succesfully removed all this user data');
        }

        $users = User::where('is_streamer', 'no')->orderByDesc('id')->get();

        return view('admin.users', compact('active', 'users'));
    }

    // adjust tokens balance
    public function adjustTokenForm(User $user)
    {
        return view('admin.adjust-token', compact('user'));
    }

    // save new tokens balance
    public function saveTokenBalance(User $user, Request $request)
    {
        $request->validate(['balance' => 'required|numeric']);
        $user->tokens = $request->balance;
        $user->save();

        if ($user->is_streamer == 'yes') {
            return redirect('/admin/streamers')->with('msg', __('Successfully adjusted balance to :newBalance for streamer @:username', ['newBalance' => $request->balance, 'username' => $user->username]));
        } else {
            return redirect('/admin/users')->with('msg', __('Successfully adjusted balance to :newBalance tokens for user :username', ['newBalance' => $request->balance, 'username' => $user->username]));
        }
    }

    // set admin role
    public function setAdminRole(User $user)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        // set as admin
        $user->is_admin = 'yes';
        $user->save();

        return back()->with('msg', 'Successfully added ' . $user->email . ' as an admin');
    }

    // remove admin role
    public function unsetAdminRole(User $user)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        // find if there is any other admin remaining.
        $adminsRemaining = User::where('is_admin', 'yes')->where('id', '!=', $user->id)->exists();

        if ($adminsRemaining) {
            $user->is_admin = 'no';
            $user->save();

            $msg = 'Successfully removed admin role of ' . $user->email;
        } else {
            $msg = 'At all points, there must be at least one admin user on this website.';
        }


        return back()->with('msg', $msg);
    }

    // ban user
    public function banUser(User $user)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        if (auth()->id() == $user->id) {
            return back()->with('msg', 'Do not ban yourself');
        }

        $msg = 'Successfully banned ' . $user->email;

        // if ip is NOT null
        if ($user->ip) {
            // add banned ip entry
            $ban = new Banned();
            $ban->ip = $user->ip;
            $ban->save();
        } else {
            $msg = 'IP not available for ban';
        }

        return back()->with('msg', $msg);
    }

    // remove user ban
    public function unbanUser(User $user)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        // removed banned ip entry
        $ban = Banned::where('ip', $user->ip)->get();

        if ($ban->count()) {
            foreach ($ban as $b) {
                $b->delete();
            }
        }

        return back()->with('msg', 'Successfully removed ban for ' . $user->email);
    }

    // login as vendor
    public function loginAsVendor($vendorId)
    {
        // get user
        $user = User::findOrFail($vendorId);

        // login
        \Auth::loginUsingId($user->id);

        return redirect(route('home'));
    }


    // categories
    public function categories_overview(Request $r)
    {
        // if remove
        if ($removeId = $r->remove) {
            if (env('IS_LIVE_DEMO', false) === true) {
                return back()->with('msg', 'No changes will be applied on this live demo.');
            }

            // does this category contain creators?
            $hasCreators = DB::select('SELECT COUNT(*) as usersCount FROM category_user WHERE category_id = ?', [$r->remove]);
            $hasCreators = reset($hasCreators);


            if ($hasCreators->usersCount != 0) {
                return redirect('admin/categories')->with('msg', 'Sorry, this category contains creators. You can only remove categories that have 0 creators using it.');
            }

            // remove from db
            $d = Category::findOrFail($removeId);
            $d->delete();

            return redirect('admin/categories')->with('msg', 'Successfully removed category');
        }


        // if update
        $catname = '';
        $catID = '';
        if ($updateCat = $r->update) {
            // find category
            $c = Category::findOrFail($updateCat);
            $catname = $c->category;
            $catID = $c->id;
        }

        $categories = Category::withCount('users')->orderBy('category')->get();

        return view('admin.categories')
            ->with('active', 'categories')
            ->with('categories', $categories)
            ->with('catname', $catname)
            ->with('catID', $catID);
    }

    // add category
    public function add_category(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $this->validate($r, ['catname' => 'required']);

        $c = new Category();
        $c->category = $r->catname;
        $c->save();

        return redirect('admin/categories')->with('msg', 'Category successfully created.');
    }

    // update category
    public function update_category(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $this->validate($r, ['catname' => 'required']);

        $c = Category::findOrFail($r->catID);
        $c->category = $r->catname;
        $c->save();

        return redirect('admin/categories')->with('msg', 'Category successfully updated.');
    }

    // VIDEO categories
    public function video_categories(Request $r)
    {
        // if remove
        if ($removeId = $r->remove) {
            if (env('IS_LIVE_DEMO', false) === true) {
                return back()->with('msg', 'No changes will be applied on this live demo.');
            }

            // does this category contain creators?
            $hasCreators = VideoCategories::withCount('videos')->find($r->remove);


            if ($hasCreators->videos_count != 0) {
                return redirect('admin/video-categories')->with('msg', 'Sorry, this category contains videos. You can only remove categories that have 0 videos.');
            }

            // remove from db
            $d = VideoCategories::findOrFail($removeId);
            $d->delete();

            return redirect('admin/video-categories')->with('msg', 'Successfully removed category');
        }


        // if update
        $catname = '';
        $catID = '';
        if ($updateCat = $r->update) {
            // find category
            $c = VideoCategories::findOrFail($updateCat);
            $catname = $c->category;
            $catID = $c->id;
        }

        $categories = VideoCategories::withCount('videos')->orderBy('category')->get();

        return view('admin.video-categories')
            ->with('active', 'categories')
            ->with('categories', $categories)
            ->with('catname', $catname)
            ->with('catID', $catID);
    }

    // add category
    public function add_video_category(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $this->validate($r, ['catname' => 'required']);

        $c = new VideoCategories();
        $c->category = $r->catname;
        $c->save();

        return redirect('admin/video-categories')->with('msg', 'Category successfully created.');
    }

    // update category
    public function update_video_category(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $this->validate($r, ['catname' => 'required']);

        $c = VideoCategories::findOrFail($r->catID);
        $c->category = $r->catname;
        $c->save();

        return redirect('admin/video-categories')->with('msg', 'Category successfully updated.');
    }

    // pages controller
    public function pages()
    {
        // get existent pages
        $pages = Page::all();

        return view('admin.pages')->with('pages', $pages)
            ->with('active', 'pages');
    }

    // create a page
    public function create_page(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        // validate form entries
        $this->validate($r, ['page_title' => 'unique:pages|required']);

        // save page
        $page = new Page();
        $page->page_title = $r->page_title;
        $page->page_slug  = Str::slug($r->page_title);
        $page->page_content = $r->page_content;
        $page->save();

        return redirect()->route('admin-cms')->with('msg', 'Page successfully created');
    }

    // update page
    public function showUpdatePage($page)
    {
        $page = Page::find($page);
        return view('admin.update-page')->with('p', $page)->with('active', 'pages');
    }

    // update page processing
    public function processUpdatePage($page, Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $page = Page::find($page);
        $page->page_title = $r->page_title;
        $page->page_content = $r->page_content;
        $page->save();

        return redirect('admin/cms-edit-' . $page->id)->with('msg', 'Page successfully updated.');
    }

    // delete page
    public function deletePage($page)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $page = Page::find($page);
        $page->delete();
        return redirect()->route('admin-cms')->with('msg', 'Page successfully deleted.');
    }

    // upload image from CMS
    public function uploadImageFromCMS(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $fileName = $r->file('file')->storePublicly('cms-uploads', 'public');

        return response()->json(['location' => asset($fileName)]);
    }


    // appearance setup
    public function appearance()
    {
        return view('admin.appearance')->with('active', 'appearance');
    }

    // payments and pricing setup
    public function paymentsSetup()
    {
        $active = 'payments';
        return view('admin.payments-setup')->with('active', $active);
    }

    // payments and pricing setup
    public function paymentsSetupProcess()
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $options = request()->except('_token', 'sb_settings');

        // save options
        foreach ($options as $name => $value) {
            if ($name == 'payment-settings_currency_symbol') {
                $name = 'payment-settings.currency_symbol';
            } elseif ($name == 'payment-settings_currency_code') {
                $name = 'payment-settings.currency_code';
            } else {
                $name = $name;
            }
            Options::update_option($name, $value);
        }

        return redirect('admin/configuration/payment')->with('msg', 'Payments settings successfully saved!');
    }

    // general configuration
    public function configuration()
    {
        $active = 'configuration';
        return view('admin.configuration', compact('active'));
    }

    // process configuration changes
    public function configurationProcess(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $options = $r->except([
            '_token',
            'sb_settings',
            'admin_current_pass',
            'admin_new_pass',
            'site_favico'
        ]);

        // save options
        foreach ($options as $name => $value) {
            Options::update_option($name, $value);
        }

        // site logo (night mode) updated?
        if ($r->hasFile('site_logo')) {
            // validate image
            $this->validate($r, ['site_logo' => 'required|mimes:jpg,png']);

            // get extension
            $ext = $r->file('site_logo')->getClientOriginalExtension();

            // set destination
            $destinationPath = public_path() . '/images/';

            // set random file name
            $fileName = uniqid(rand()) . '.' . $ext;

            // upload the logo
            $r->file('site_logo')->move($destinationPath, $fileName);

            // update option
            Options::update_option('site_logo', '/images/' . $fileName);
        }

        // site logo (day mode) updated?
        if ($r->hasFile('site_logo_footer')) {
            // validate image
            $this->validate($r, ['site_logo_footer' => 'required|mimes:jpg,png']);

            // get extension
            $ext = $r->file('site_logo_footer')->getClientOriginalExtension();

            // set destination
            $destinationPath = public_path() . '/images/';

            // set random file name
            $fileName = uniqid(rand()) . '.' . $ext;

            // upload the logo
            $r->file('site_logo_footer')->move($destinationPath, $fileName);

            // update option
            Options::update_option('site_logo_footer', '/images/' . $fileName);
        }

        // favico updated?
        if ($r->hasFile('site_favico')) {
            // validate favicon
            $this->validate($r, ['site_favico' => 'required|mimes:jpg,png']);

            // get extension
            $ext = $r->file('site_favico')->getClientOriginalExtension();

            // set destination
            $destinationPath = public_path() . '/images/';

            // set random file name
            $fileName = uniqid(rand()) . '.' . $ext;

            // upload the logo
            $r->file('site_favico')->move($destinationPath, $fileName);


            // update option
            Options::update_option('favicon', '/images/' . $fileName);
        }

        return redirect('admin/configuration')->with('msg', 'Configuration settings successfully saved!');
    }

    // streaming configuration
    public function streamingConfig()
    {
        $active = 'streaming';
        return view('admin.streaming-config', compact('active'));
    }

    // save streaming configuration
    public function saveStreamingConfig(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $inputs = $r->only(['RTMP_URL']);

        foreach ($inputs as $key => $val) {
            $this->__updateEnvKey($key, $val);
        }

        return back()->with('msg', __('RTMP URL successfully saved'));
    }

    // chat configuration
    public function chatConfig()
    {
        $active = 'chat';
        return view('admin.chat-config', compact('active'));
    }

    // save chat configuration
    public function saveChatConfig(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $inputs = $r->only(['PUSHER_APP_KEY', 'PUSHER_APP_ID', 'PUSHER_APP_SECRET', 'PUSHER_APP_CLUSTER']);

        foreach ($inputs as $key => $val) {
            $this->__updateEnvKey($key, $val);
        }

        return back()->with('msg', __('Pusher app details successfully saved'));
    }


    // extra CSS / JS
    public function extraCSSJS()
    {
        $active = 'cssjs';

        return view('admin.cssjs', compact('active'));
    }


    // save extra css/js
    public function saveExtraCSSJS(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        Options::update_option('admin_extra_CSS', $r->admin_extra_CSS);
        Options::update_option('admin_extra_JS', $r->admin_extra_JS);
        Options::update_option('admin_raw_JS', $r->admin_raw_JS);

        return back()->with('msg', 'Successfully updated extra CSS/JS');
    }

    // mail configuration
    public function mailconfiguration()
    {
        return view('admin/mail-configuration', ['active' => 'mailconfig']);
    }

    // update mail configuration
    public function updateMailConfiguration(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        try {
            $i = $r->except(['sb_settings', '_token']);

            foreach ($i as $k => $v) {
                $this->__updateEnvKey($k, $v);
            }

            $msg = 'Mail Configuration settings successfully saved!';
        } catch (\Exception $e) {
            $msg = $e->getMessage();
        }

        return redirect('admin/mailconfiguration')->with('msg', $msg);
    }

    // mail test
    public function mailtest()
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        try {
            $data['message'] = 'This is a test email to check your mail server configuration.';

            $data['intromessage'] = 'Mail Server Configuration';
            $data['url'] = env('APP_URL') . '/admin/mailconfiguration';
            $data['buttonText'] = 'See Mail Configuration';

            $adminEmail = User::where('is_admin', 'yes')->first();


            \Mail::send('emails.test-email', ['data' => $data], function ($m) use ($adminEmail, $data) {
                $m->from(env('MAIL_FROM_ADDRESS'));
                $m->to($adminEmail->email);
                $m->subject('Email Configuration Test');
            });

            return redirect('admin/mailconfiguration')->with('msg', 'Mail sent to your server, it is up to them to deliver it now.');
        } catch (\Exception $e) {
            return redirect('admin/mailconfiguration')->with('msg', $e->getMessage());
        }
    }


    // show cloud settings page
    public function cloudSettings()
    {
        $active = 'cloud';
        return view('admin.cloud-settings', compact('active'));
    }

    // save cloud settings
    public function saveCloudSettings(Request $r)
    {
        if (env('IS_LIVE_DEMO', false) === true) {
            return back()->with('msg', 'No changes will be applied on this live demo.');
        }

        $options = $r->except([
            '_token', 'sb_settings',
        ]);

        // save options
        foreach ($options as $name => $value) {
            $this->__updateEnvKey($name, $value);
        }

        return back()->with('msg', 'Cloud storage settings successfully saved');
    }


    // configure entry popup
    public function entryPopup()
    {
        $active = 'popup';
        return view('admin.entry-popup', compact('active'));
    }

    // save entry popup settings
    public function entryPopupSave(Request $r)
    {
        $options = request()->except('_token', 'sbPopup');

        // save options
        foreach ($options as $name => $value) {
            Options::update_option($name, $value);
        }

        return back()->with('msg', 'Report successfully removed.');
    }
}
