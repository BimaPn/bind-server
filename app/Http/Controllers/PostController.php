<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Support\Str;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getPosts()
    {
        $posts = Post::limit(10)->get()->map(function (Post $post) {
            return $post->getPreviewData();
        });
        return response()->json([
            'posts' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'posts' => $post
        ]);
    }

    /**
     * Store a newly added resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();
        if($validatedData['caption'] == null && !$request->hasFile('media')) {
            return response()->json([
                'errors' => "please input caption or image"
            ],422);
        }
        $post = Post::create([
            'id' => Str::uuid(),
            'group_id' => $request->group_id != null ? $request->group_id : null,
            'user_id' => auth()->user()->id,
            'caption' => $validatedData['caption'],
        ]);

        if($request->hasFile('media'))
        {
            foreach ($validatedData['media'] as $media) {
                $media = url('/storage/'.$media->store('/post'));
                PostMedia::create([
                    'id' => Str::uuid(),
                    'post_id' => $post->id,
                    'file_path' => $media,
                ]);
            }
        }

        return response()->json([
            'post' => $post->getPreviewData()
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validatedData = $request->validated();
        if($validatedData['caption'] == null && !$request->hasFile('media')) {
            return response()->json([
                'errors' => "please input caption or image"
            ],422);
        }

        $post->update([
            'caption' => $validatedData['caption']
        ]);

        if($request->has('media_delete_id'))
        {
            foreach ($request->media_delete_id as $id) {
                $media = $post->media()->find($id);
                $media->deleteFile();
                $media->delete();
            }
        }

        if($request->hasFile('media_new'))
        {
            foreach ($validatedData['media_new'] as $media) {
                $media = url('/storage/'.$media->store('/post'));
                PostMedia::create([
                    'id' => Str::uuid(),
                    'post_id' => $post->id,
                    'file_path' => $media,
                ]);
            }
        }

        return response()->json([
            'post' => $post->getPreviewData()
        ]);
    }
    public function edit(Post $post)
    {
        return response()->json([
            'post' => [
                'profile_picture' => $post->author->profile_picture,
                'caption' => $post->caption,
                'media' => $post->media()->select('id','file_path')->get()
            ]
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('forceDelete', $post);

        if($post->media){
            foreach($post->media as $item){
                $path = parse_url($item->file_path);
                $storagePath = public_path();
                $fullPath = $storagePath . str_replace('/','\\',$path['path']);
                File::delete($fullPath);
            }
        }

        Post::destroy($post->id);

        return response()->json([
            'message' => 'Post deleted.'
        ]);
    }
}
