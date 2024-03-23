<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inbox()
    {
        $notifications = auth()->user()->notifications()->orderByDesc('created_at')->paginate(12);

        return Inertia::render('Profile/Notifications', compact('notifications'));
    }

    public function markAsRead($notification)
    {
        $notification = auth()->user()->notifications()->where('id', $notification)->firstOrFail();

        $notification->markAsRead();

        return back()->with('message', __("Marked as Read"));
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('message', __("Marked All as Read"));
    }
}
