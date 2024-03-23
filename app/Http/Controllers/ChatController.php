<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageEvent;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;

class ChatController extends Controller
{
    // latest messages
    public function latestMessages(String $roomName)
    {
        $messages = Chat::where('roomName', $roomName)
                        ->latest()
                        ->take(50)
                        ->get();

        return $messages->reverse()
                        ->flatten();
    }

    // send message
    public function sendMessage(User $user, Request $request)
    {
        if (!auth()->check()) {
            return abort(403, __("You must be logged in to chat!"));
        }

        $request->validate(['message' => 'required']);

        $roomName = 'room-' . $user->username;

        $chat = Chat::create([
            'roomName' => $roomName,
            'user_id' => $request->user()->id,
            'streamer_id' => $user->id,
            'message' => $request->message
        ]);


        broadcast(new ChatMessageEvent($chat));

        return response()->json(['result' => $chat->id]);
    }
}
