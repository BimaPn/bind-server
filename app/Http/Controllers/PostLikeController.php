<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function like(Post $post)
    {
        $liked = PostLike::firstWhere([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id
        ]);

        if($liked){
            return response()->json([
                'message' => 'You already liked this post.'
            ]);
        }

        PostLike::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'post_id' => $post->id
        ]);

        return response()->json([
            'message' => 'Post liked.'
        ]);
    }

    public function unlike(Post $post)
    {
        $liked = PostLike::firstWhere([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id
        ]);

        if(!$liked){
            return response()->json([
                'message' => 'You have not liked this post.'
            ]);
        }

        $liked->delete();

        return response()->json([
            'message' => 'Post unliked.'
        ]);
    }
}
