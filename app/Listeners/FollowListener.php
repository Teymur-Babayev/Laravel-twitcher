<?php

namespace App\Listeners;

use App\Notifications\NewFollower;
use App\Models\User;
use Overtrue\LaravelFollow\Events\Followed;

class FollowListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    //
    }

    /**
     * Handle the event.
     *
     * @param  Followd  $event
     * @return void
     */
    public function handle(Followed $event)
    {
        // get followed user
        $followed = User::findOrFail($event->followable_id);

        // get follower profile
        $follower = User::select('id', 'username', 'profile_picture')
                            ->without('firstCategory')
                            ->findOrFail($event->follower_id);

        // send notification
        $followed->notify(new NewFollower($follower));

        // increase popularity of this user
        $followed->increment('popularity', 5);
    }
}
