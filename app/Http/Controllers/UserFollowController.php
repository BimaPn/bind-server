<?php

namespace App\Http\Controllers;

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

        NotificationController::create("users", 1, auth()->id(), $user->id);

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
}
