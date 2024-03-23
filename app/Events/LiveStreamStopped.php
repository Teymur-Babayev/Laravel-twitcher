<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LiveStreamStopped implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public User $user)
    {
        // update user status
        $user->live_status = 'offline';
        $user->save();


        Log::info('Channel room-' . $user->username . ' offline');

        // clear chat session
        Chat::where('streamer_id', $user->id)->delete();
    }

    public function broadcastOn()
    {
        return [new Channel('room-' . $this->user->username)];
    }

    public function broadcastAs()
    {
        return 'livestream.stopped';
    }

    public function broadcastWith(): array
    {
        return ['channel' => 'room-' . $this->user->username];
    }
}
