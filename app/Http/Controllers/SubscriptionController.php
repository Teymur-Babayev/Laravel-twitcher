<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Tier;
use App\Models\User;
use App\Notifications\NewSubscriber;
use App\Notifications\ThanksNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function isSubscribedTo(User $user, Request $request)
    {
        if ($request->user()->hasSubscriptionTo($user)) {
            return $request->user()->subscriptions()
                            ->where('subscription_expires', '>=', now())
                            ->where('streamer_id', $user->id)
                            ->first()['tier_id'];
        }

        return 0;
    }

    public function mySubscribers(Request $request)
    {
        Gate::authorize('channel-settings');

        $subs = $request->user()
                    ->subscribers()->with('subscriber')
                    ->paginate(8);

        return Inertia::render('Channel/MySubscribers', compact('subs'));
    }

    public function mySubscriptions(Request $request)
    {
        $subs = $request->user()
                    ->subscriptions()->with('streamer')
                    ->paginate(2);

        return Inertia::render('Profile/MySubscriptions', compact('subs'));
    }

    public function selectGateway($channel, Tier $tier)
    {
        $channel = User::isStreamer()
                        ->where('username', $channel)
                        ->firstOrFail();

        if ($tier->user_id !== $channel->id) {
            abort(403);
        }

        if ($channel->id == auth()->id()) {
            return back()->with('message', __('Do not subscribe to yourself'));
        }

        return Inertia::render('Channel/Subscribe', compact('channel', 'tier'));
    }

    public function confirmSubscription(User $user, Tier $tier, Request $request)
    {
        // basic validations
        if ($user->is_streamer !== 'yes') {
            abort(403, __("User is not a streamer"));
        } elseif ($tier->user_id !== $user->id) {
            abort(403, __("Tier is not owned by this streamer"));
        } elseif (!$request->has('plan')) {
            abort(403, __("Plan is required in order to subscribe"));
        }

        // check plan legitimacy
        $plan = $request->plan;

        if (!in_array($plan, ['Monthly', '6 Months', 'Yearly'])) {
            abort(403, __("Plan not reckognized"));
        }

        // compute price for this channel & tier + plan combo
        $price = match ($plan) {
            'Monthly' => $tier->price,
            '6 Months' => $tier->six_months_price,
            'Yearly' => $tier->yearly_price,
        };

        // check authenticated user balance against price
        if ($request->user()->tokens < $price) {
            abort(403, __("Your balance of :balance tokens is not enough to buy a plan for :planPrice tokens", ['balance' => $request->user()->tokens, 'planPrice' => $price]));
        }

        // compute expiration
        $expiration = match ($plan) {
            'Monthly' => strtotime("+1 Month"),
            '6 Months' => strtotime("+6 Months"),
            'Yearly' => strtotime("+1 Year"),
        };

        // create subscription and subtract balance
        $subscription = new Subscription();

        $subscription->tier_id = $tier->id;
        $subscription->streamer_id = $user->id;
        $subscription->subscriber_id = $request->user()->id;
        $subscription->subscription_date = now();
        $subscription->subscription_expires = $expiration;
        $subscription->status = 'Active';
        $subscription->subscription_tokens = $price;
        $subscription->save();

        // subtract from user balance
        $request->user()->decrement('tokens', $price);

        // increase popularity by 10
        $user->increment('popularity', 10);

        try {
            // notify creator
            $user->notify(new NewSubscriber($subscription));

            // notify the subscribe with thanks message if any
            if ($thanksMessage = user_meta('thanks_message', true, $user->id)) {
                $request->user()->notify(new ThanksNotification($subscription, $thanksMessage));
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }


        return to_route('channel', ['user' => $user->username])->with('message', __("Thank you, Your subscription is now Active"));
    }
}
