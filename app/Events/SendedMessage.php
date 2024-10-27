<?php

namespace App\Events;

use App\Models\LastSeenMessage;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendedMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $message;
    public $userId;
    public $isPreviousUnreadExist = false;

    public function __construct(Message $message, $userId, $currentTime)
    {
        $this->message = $message;

        $lastSeen = LastSeenMessage::where([["user_id", $userId], ["target_id", auth()->id()]])->first();
        if($lastSeen) {
            $unreadMessage = Message::where("sender_id",auth()->id())
                                ->where("receiver_id",$userId)
                                ->where("created_at","<",$currentTime)
                                ->where("created_at",">",$lastSeen->last_seen)
                                ->first();
            if($unreadMessage) {
                $this->isPreviousUnreadExist = true;
            }
        }
        $this->message->isRead = false;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.'.$this->userId),
        ];
    }

    public function broadcastWith(){
        return [
            'message' => $this->message,
            'user' => [
                "username" => auth()->user()->username,
                "name" => auth()->user()->name,
                "profile_picture" => auth()->user()->profile_picture
            ],
            "isPreviousUnreadExist" => $this->isPreviousUnreadExist
        ];
    }
}
