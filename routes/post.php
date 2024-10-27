<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostSaveController;

// Post
Route::get('/posts', [PostController::class, 'getPosts'])->middleware('api');
Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'post'
], function ($router) {
    Route::get('/{post}', [PostController::class, 'show']);
    Route::get('/{post}/edit', [PostController::class, 'edit']);
    Route::post('/create', [PostController::class, 'store']);
    Route::put('/{post}/update', [PostController::class, 'update']);
    Route::delete('/{post}/delete', [PostController::class, 'destroy']);
    Route::post('/{post}/like', [PostLikeController::class, 'like']);
    Route::post('/{post}/unlike', [PostLikeController::class, 'unlike']);
    Route::get('/{post}/comments', [PostCommentController::class, 'getPostComments']);
    Route::post('/{post}/comment', [PostCommentController::class, 'comment']);
    Route::post('/{comment}/delete', [PostCommentController::class, 'deleteComment']);
    Route::post('/{post}/save', [PostSaveController::class, 'save']);
    Route::post('/{post}/unsave', [PostSaveController::class, 'unsave']);
});
