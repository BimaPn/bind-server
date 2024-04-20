<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostSave;
use Illuminate\Support\Str;

class PostSaveController extends Controller
{
    public function save(Post $post)
    {
        $saved = $post->savesPivot()->firstWhere([
            'user_id' => auth()->id(),
            'post_id' => $post->id
        ]);

        if($saved){
            return response()->json([
                'message' => 'You already saved this post.'
            ], 422);
        }

        PostSave::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'post_id' => $post->id
        ]);

        return response()->json([
            'message' => 'you saved the post'
        ]);
    }

    public function unsave(Post $post)
    {
        $saved = $post->savesPivot()->firstWhere([
            'user_id' => auth()->id(),
            'post_id' => $post->id
        ]);

        if(!$saved){
            return response()->json([
                'message' => 'You have not save this post.'
            ], 422);
        }

        $saved->delete();

        return response()->json([
            'message' => 'Post unsaved.'
        ]);
    }
}
