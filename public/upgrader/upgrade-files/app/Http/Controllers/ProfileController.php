<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\TokenSale;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use App\Models\User;
use Image;

class ProfileController extends Controller
{
    // auth middleware
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill(Arr::except($request->validated(), ['profilePicture']));

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // save profile picture if needed
        if ($request->hasFile('profilePicture')) {
            $profilePicture = Image::make($request->file('profilePicture'));
            $picturePath = 'profilePics/' . $request->user()->id . '-' . uniqid() . '.' . $request->file('profilePicture')->getClientOriginalExtension();

            $profilePicture->fit(80, 80, function ($constrain) {
                $constrain->upsize();
            })->save(public_path($picturePath), 100);

            $request->user()->profile_picture = $picturePath;
            $request->user()->save();
        }

        return Redirect::route('profile.edit')->with('message', __('Account details updated.'));
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function toggleFollow(User $user)
    {
        if (auth()->user()->id != $user->id) {
            auth()->user()->toggleFollow($user);

            return response()->json(['result' => 'ok']);
        } else {
            return response()->json(['error' => __("You can't follow yourself")], 403);
        }
    }

    public function followings(Request $request)
    {
        $following = $request->user()->followings()->with('followable')->get();

        return Inertia::render('Profile/Following', compact('following'));
    }

    public function myTokens()
    {
        $orders = TokenSale::where('user_id', auth()->user()->id)
            ->where('status', 'paid')
            ->paginate(10);

        return Inertia::render('Profile/TokenOrders', compact('orders'));
    }


    public function modalUserInfo(User $user, Request $r)
    {
        $membershipTier = null;
        $banned_date = null;

        $subscription = $user->subscriptions()
            ->where('streamer_id', auth()->user()->id)
            ->where('subscription_expires', '>=', now())
            ->first();

        if ($subscription) {
            $membershipTier = $subscription->created_at;
        }

        $ban = $user->bannedFromRooms()->where('streamer_id', auth()->user()->id)->first();
        if ($ban) {
            $banned_date = $ban->created_at->format('Y-m-d H:i:s');
        }


        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'profile_picture' => $user->profile_picture,
            'channel_follower' => $user->isFollowing(auth()->user()),
            'channel_member' => $user->hasSubscriptionTo(auth()->user()),
            'membership_tier' => $membershipTier,
            'is_admin' => $user->is_admin === 'yes',
            'is_user_banned' => $user->bannedFromRooms()->where('streamer_id', auth()->user()->id)->exists(),
            'banned_date' => $banned_date
        ];
    }
}
