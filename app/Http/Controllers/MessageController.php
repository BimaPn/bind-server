<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index (User $user)
    {
        $senderId = auth()->user()->id;
        $receiverId = $user->id;

        $messages = Message::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $senderId);
        })->orderBy('created_at', 'desc')->get();

        $messages->each(function ($message) use ($senderId) {
            $message->IsCurrentAuth = $message->sender_id == $senderId;
        });

        return response()->json([
            "message" => "Success",
            "messages" => $messages
        ]);
    }

    public function getChatList ()
    {
        $authId = auth()->user()->id;

        $subquery = Message::select('sender_id', 'receiver_id', DB::raw('MAX(created_at) as last_message_date'))
        ->where('sender_id', $authId)
        ->orWhere('receiver_id', $authId)
        ->groupBy('sender_id', 'receiver_id');

        $chats = Message::select('sender_id', 'receiver_id', 'message', 'created_at')
        ->whereIn('created_at', function ($query) use ($subquery) {
            $query->select('last_message_date')
                ->fromSub($subquery, 'subquery');
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            "message" => "chat list",
            "chats" => $chats
        ]);
    }

    public function create (User $user, Request $request)
    {
        $validatedData = $request->validate([
            "message" => "required"
        ]);

        Message::create([
            "id" => Str::uuid(),
            "sender_id" => auth()->user()->id,
            "receiver_id" => $user->id,
            "message" => $validatedData["message"]
        ]);

        return response()->json([
            "message" => "success"
        ]);
    }
}
