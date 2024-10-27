<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;

class PostCommentController extends Controller
{
    public function getPostComments(Post $post)
    {
        $comments = $post->comments->map(function (PostComment $comment) {
            return [
                'id' => $comment->id,
                'user' => [
                    'name' => $comment->author->name,
                    'profile_picture' => $comment->author->profile_picture,
                    'isVerified' => $comment->author->isVerified()
                ],
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->diffForHumans()
            ];
        });
        return response()->json([
            'comments' => $comments,
            'commentTotal' => $post->comments->count()
        ]);
    }
    public function comment(StoreCommentRequest $request, Post $post)
    {
        $validatedData = $request->validated();

       $comment = PostComment::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comment' => $validatedData['comment']
        ]);

        return response()->json([
            'commentId' => $comment->id,
            'comment' => $comment->comment
        ]);
    }

    public function deleteComment(PostComment $comment)
    {
        $this->authorize('forceDelete',$comment);

        PostComment::destroy($comment->id);

        return response()->json([
            'message' => 'Comment deleted.'
        ]);
    }
}
