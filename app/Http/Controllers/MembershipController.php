<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class MembershipController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function saveThanks(Request $request)
    {
        Gate::authorize('channel-settings');

        $request->validate(['thanks_message' => 'required']);

        set_user_meta('thanks_message', $request->thanks_message);

        return back()->with('message', __('Thanks message updated!'));
    }

    public function setMembershipTiers(Request $request)
    {
        Gate::authorize('channel-settings');

        $tiers = $request->user()
                            ->tiers()
                            ->withCount('subscribers')
                            ->orderBy('price')
                            ->get();

        $thanksMsg = user_meta('thanks_message');

        return Inertia::render('Membership/Set-Tiers', compact('tiers', 'thanksMsg'));
    }

    public function addTier(Request $request)
    {
        Gate::authorize('channel-settings');

        $request->validate(['tier_name' => 'required',
        'tier_price' => 'required|numeric',
        'perks' => 'required',
        'six_months_discount' => 'required|numeric|between:1,99',
        'one_year_discount' => 'required|numeric|between:1,99'
        ]);

        $request->user()->tiers()->create([
            'tier_name' => $request->tier_name,
            'price' => $request->tier_price,
            'six_months_discount' => $request->six_months_discount,
            'one_year_discount' => $request->one_year_discount,
            'perks' => $request->perks
        ]);

        return back()->with('message', __('Tier succesfully saved'));
    }

    public function editTier(Tier $tier, Request $request)
    {
        Gate::authorize('channel-settings');

        if ($tier->user_id !== $request->user()->id) {
            abort(403);
        }


        return Inertia::render('Membership/Edit-Tier', compact('tier'));
    }

    public function updateTier(Tier $tier, Request $request)
    {
        Gate::authorize('channel-settings');

        if ($tier->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->validate(['tier_name' => 'required',
        'tier_price' => 'required|numeric',
        'six_months_discount' => 'required|numeric|between:1,99',
        'one_year_discount' => 'required|numeric|between:1,99',
        ]);

        $tier->update([
             'tier_name' => $request->tier_name,
             'price' => $request->tier_price,
             'six_months_discount' => $request->six_months_discount,
             'one_year_discount' => $request->one_year_discount,
             'perks' => $request->perks
         ]);

        return to_route('membership.set-tiers')->with('message', __('Tier succesfully updated'));
    }

    public function deleteTier(Request $request)
    {
        Gate::authorize('channel-settings');

        if (Subscription::where('tier_id', $request->tier)->where('subscription_expires', '>=', now())->count()) {
            return back()->with('message', __('You cannot delete a tier which has active subscribers'));
        }

        $request->user()->tiers()->findOrFail($request->tier)->delete();

        return back()->with('message', __('Tier removed'));
    }
}
