<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageEvent;
use App\Models\Chat;
use App\Models\Tips;
use App\Models\User;
use Illuminate\Http\Request;

class TipsController extends Controller
{
    // auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    // send tip
    public function sendTip(Request $request)
    {
        $request->validate([
            'streamer' => 'required|exists:users,id',
            'message' => 'required',
            'tip' => 'required|numeric|min:1',
        ]);

        // don't tip yourself
        if ($request->user()->id == $request->streamer) {
            return response()->json(['result' => __("Do not tip yourself!")]);
        }

        // validate balance is enough
        if ($request->tip > $request->user()->tokens) {
            return response()->json([
                'result' =>__("Your balance of :tokens tokens is not enough for a tip of :tip", [
                    'tokens' => $request->user()->tokens,
                    'tip' => $request->tip
                ])
            ]);
        }

        // get streamer
        $streamer = User::findOrFail($request->streamer);

        // record tip
        $tip = new Tips();
        $tip->user_id = $request->user()->id;
        $tip->streamer_id = $streamer->id;
        $tip->tokens = $request->tip;
        $tip->save();

        // subtract tipper balance
        $request->user()->decrement('tokens', $request->tip);

        // increment streamer balance
        $streamer->increment('tokens', $request->tip);

        // broadcast message
        $message = new Chat();
        $message->roomName = 'room-' . $streamer->username;
        $message->streamer_id = $streamer->id;
        $message->user_id = $request->user()->id;
        $message->tip = $request->tip;
        $message->message = $request->message;
        $message->save();

        broadcast(new ChatMessageEvent($message));

        return response()->json(['result' => 'ok']);
    }
}
