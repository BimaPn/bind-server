<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function show(User $user)
    {
        $showUser = $user->getData();
        if(!($user->id == auth()->user()->id))
        {
            $showUser['isFollow'] = auth()->user()->isFollowing($user);
        }else {
            $showUser['isFollow'] = false;
        }
        return response()->json([
            'user' => $showUser
        ]);
    }

    public function update(UpdateUserRequest $request,User $user)
    {
        $validatedData = $request->validated();

        if($request->file('profile_picture')){
            $validatedData['profile_picture'] = url('/storage/'.$request->file('profile_picture')->store('/user/profile'));
            $user->deleteProfilePicture();
        }
        if($request->file('cover_photo')){
            $validatedData['cover_photo'] = url('/storage/'.$request->file('cover_photo')->store('/user/cover'));
            $user->deleteCoverPhoto();
        }

        $user->update($validatedData);

        return response()->json([
            'user' => $user->getData(),
        ], 200);
    }

    public function destroy(User $user)
    {
        $this->authorize('forceDelete',$user);

        if($user->profile_picture){
            Storage::delete($user->profile_picture);
        }

        if($user->cover_photo){
            Storage::delete($user->cover_photo);
        }

        User::destroy($user->id);

        return response()->json([
            'message' => 'Account deleted.'
        ]);
    }
    public function getUserPosts(User $user)
    {
        $posts = $user->posts->map(function (Post $post) {
            return $post->getPreviewData();
        });
        return response()->json([
            'posts' => $posts
        ]);
    }
    public function getPostsSaved ()
    {
        $postsSaved = auth()->user()->postSaved->map(function (Post $post) {
            return $post->getPreviewData();
        });
        return response()->json([
            'posts' => $postsSaved
        ]);
    }
}
