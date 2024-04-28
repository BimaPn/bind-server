<?php

namespace App\Http\Controllers;

use App\Events\SendedNotification;
use App\Models\User;

class UserFollowController extends Controller
{
    public function follow(User $user)
    {
        $authUser = auth()->user();

        $this->authorize('follow', $authUser);

        if($user->username === $authUser->username){
            return response()->json([
                'message' => 'Cannot follow yourself.'
            ], 422);
        }else if($authUser->isFollowing($user)){
            return response()->json([
                'message' => 'You have followed ' . $user->username
            ], 422);
        }

        $authUser->follow($user);

        $this->createNotification($authUser, $user->id);

        return response()->json([
            'message' => 'You followed ' . $user->username
        ]);
    }

    public function unfollow(User $user)
    {
        $authUser = auth()->user();
        $this->authorize('unfollow', $authUser);

        if($user->username === $authUser->username){
            return response()->json([
                'message' => 'Cannot unfollow yourself.'
            ], 422);
        }else if(!$authUser->isFollowing($user)){
            return response()->json([
                'message' => 'You have not follow this account.'
            ], 422);
        }

        $authUser->unfollow($user);

        return response()->json([
            'message' => 'You unfollowed ' . $user->username
        ]);
    }

    public function createNotification ($authUser, $notifierId)
    {
        $message = NotificationController::create("users", 1, $authUser->id, $notifierId);
        $newNotification = [
            "sender" => [
                "name" => $authUser->name,
                "profile_picture" => $authUser->profile_picture
            ],
            "message" => $message,
            "entity" => [
                "name" => "users",
                "identifier" => $authUser->id,
                "message" => null
            ]
        ];

        SendedNotification::dispatch($newNotification);
    }
}
