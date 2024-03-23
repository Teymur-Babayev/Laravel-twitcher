<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\StreamerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class StreamerVerificationController extends Controller
{
    // auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    // form
    public function verifyForm()
    {
        Gate::authorize('channel-settings');
        return Inertia::render('Channel/StreamerVerification');
    }

    // pending message
    public function pendingVerification()
    {
        Gate::authorize('channel-settings');
        return Inertia::render('Channel/VerificationPending');
    }

    // process
    public function submitVerification(Request $request)
    {
        Gate::authorize('channel-settings');

        $request->validate(['document' => 'required|mimes:jpg,png']);

        // temporary upload to be able to attach in mail
        // it gets deleted in the Event Listener
        $doc = $request->file('document')->store('streamer-vdocs');

        $request->session()->flash('message', __("Your verification request will be processed and you will be notified by email."));

        // find admin
        $admin = User::where('is_admin', 'yes')->firstOrFail();
        $admin->notify(new StreamerVerification($doc));

        // set pending
        $request->user()->update(['streamer_verification_sent' => true]);

        return to_route('streamer.pendingVerification');
    }
}
