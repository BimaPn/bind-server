<?php

namespace App\Http\Controllers;

use App\Events\SendedMessage;
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

        $messages = Message::whereIn("sender_id", [$senderId, $receiverId])
                           ->whereIn("receiver_id", [$senderId, $receiverId])
                           ->orderBy("created_at","asc")
                           ->select("id","sender_id","message","created_at")
                           ->get();

        $messages->each(function($message) use($senderId) {
            $message->isCurrentAuth = $message->sender_id == $senderId;
            unset($message->sender_id);
        });

        return response()->json([
            "message" => "Success",
            "messages" => $messages,
            "userTarget" => [
                "name" => $user->name,
                "profile_picture" => $user->profile_picture,
                "username" => $user->username
            ]
        ]);
    }

    public function getChatList ()
    {
        $senderId = auth()->user()->id;

        $chats = DB::table("messages")
          ->join(DB::raw("(SELECT CASE WHEN sender_id = '$senderId' THEN receiver_id ELSE sender_id END as user,
                MAX(created_at) as max_created
                FROM messages WHERE sender_id = '$senderId' OR receiver_id = '$senderId'
                GROUP BY user) as last_messages"), function ($join) {
                $join->on('messages.created_at','=','last_messages.max_created');
                })
                ->orderBy("messages.created_at", "desc")
                ->select("user","message","created_at")
                ->get();

        $chats->each(function($chat) use($senderId) {
            $user = User::select("username", "name", "profile_picture")->find($chat->user);
            $chat->user = $user;
        });

        return response()->json([
            "message" => "success",
            "result" => $chats
        ]);
    }

    public function create (User $user, Request $request)
    {
        $validatedData = $request->validate([
            "message" => "required"
        ]);

        $message = Message::create([
            "id" => Str::uuid(),
            "sender_id" => auth()->user()->id,
            "receiver_id" => $user->id,
            "message" => $validatedData["message"]
        ]);

        SendedMessage::dispatch($message, $user->id);

        return response()->json([
            "message" => [
                "id" => $message->id,
                "message" => $message->message,
                "created_at" => $message->created_at,
                "isCurrentAuth" => true
            ]
        ]);
    }
}
