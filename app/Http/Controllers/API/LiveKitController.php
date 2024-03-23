<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Events\LiveStreamRefresh;
use App\Events\LiveStreamStarted;
use App\Events\LiveStreamStopped;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\UserMeta;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LiveKitController extends Controller
{
    // validate streaming key
    public function validateKey(Request $request)
    {
        $request->validate([
            'call' => 'required|in:publish,publish_done',
            'name' => 'required'
        ]);

        // validate user exists in our system
        $meta = UserMeta::where('meta_value', $request->name)
                            ->where('meta_key', 'streaming_key')->firstOrFail();

        // find user
        $user = User::findOrFail($meta->user_id);

        // set username
        $username = $user->username;

        Log::info('validateKey@' . $username);
        Log::info('key = ' . $request->name);

        // if online
        if ($request->call === "publish") {
            $this->setChannelStatus('online', $username);

            // fire socket event
            broadcast(new LiveStreamStarted($user));
            broadcast(new LiveStreamRefresh());
        } else {
            $this->setChannelStatus('offline', $username);

            // fire socket event
            broadcast(new LiveStreamStopped($user));
            broadcast(new LiveStreamRefresh());
        }

        // return ok
        return response('OK');
    }

    // set channel status
    private function setChannelStatus($status, $channelName)
    {
        // find the channel by name
        $channel = User::where('username', str_replace('channel-', '', $channelName))->firstOrFail();

        // update and save the status
        $channel->live_status = $status;
        $channel->save();
    }

    // update own channel status
    public function updateOwnStatus(Request $request)
    {
        $request->validate(['new_status' => "required|in:online,offline"]);

        if (!$request->user()) {
            abort(403, __("Unauthenticated"));
        }

        if ($request->user()->username != $request->username) {
            abort(403, __("Can only update own channel status"));
        }

        $request->user()->update(['live_status' => $request->new_status]);

        if ($request->new_status === "online") {
            // fire socket event
            broadcast(new LiveStreamStarted($request->user()));
            broadcast(new LiveStreamRefresh());
        }

        return response()->json(['result' => 'ok']);
    }
}
