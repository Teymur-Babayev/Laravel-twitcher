<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\AdminPayoutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PayoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }


    public function withdraw(Request $request)
    {
        Gate::authorize('channel-settings');

        // withdrawals
        $pendingCount = $request->user()->withdrawals()->where('status', 'Pending')->count();
        $withdrawals = $request->user()->withdrawals()->orderByDesc('id')->get();

        // payout destination
        $payoutDestination = user_meta('payout_destination');
        $payoutDetails = user_meta('payout_details');
        $payoutSettings = ['destination' => $payoutDestination, 'details' => $payoutDetails];

        return Inertia::render('Payout/Withdraw', compact('pendingCount', 'withdrawals', 'payoutSettings'));
    }


    public function saveRequest(Request $request)
    {
        Gate::authorize('channel-settings');

        $request->validate(['tokens' => 'required|numeric|min:' . opt('min_withdraw') .'|max:' . auth()->user()->tokens]);

        // validate no other pending requests
        if ($request->user()->withdrawals()->where('status', 'Pending')->count()) {
            return back()->with('msg', __('You already have a pending withdrawal request.'));
        }

        // validate payout destination set
        if (!user_meta('payout_destination')) {
            return back()->with('msg', __('Payout destination not set'));
        }

        // compute amount in money
        $amount = number_format(($request->tokens*opt('token_value')), 2);

        // save
        $withdraw = $request->user()->withdrawals()->create(['tokens' => $request->tokens, 'amount' => $amount]);

        // notify admin via email
        $admin = User::where('is_admin', 'yes')->first();

        try {
            $admin->notify(new AdminPayoutRequest($withdraw));
        } catch(\Exception $e) {
            Log::error('Email notification for AdminPayoutRequest results in exception');
            Log::error($e->getMessage());
        }

        // return back with message
        return back()->with('message', __("Payout request successfully sent"));
    }

    // save payout details
    public function saveSettings(Request $request)
    {
        Gate::authorize('channel-settings');

        $request->validate(['payout_destination' => 'required', 'payout_details' => 'required']);

        set_user_meta('payout_destination', $request->payout_destination);
        set_user_meta('payout_details', $request->payout_details);

        return back()->with('message', __("Payout settings saved"));
    }

    // save payout details
    public function cancelRequest(Request $request)
    {
        Gate::authorize('channel-settings');

        $request->validate(['withdrawal_id' => 'required|exists:withdrawals,id']);

        $w = $request->user()->withdrawals()->findOrFail($request->withdrawal_id);

        $w->status = "Canceled";
        $w->save();


        return back()->with('message', __("Payout request successfully canceled."));
    }
}
