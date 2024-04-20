<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFollowController;
use App\Http\Controllers\GroupUserPivotController;

// User
Route::get('/users', [UserController::class, 'index'])->middleware('api');
Route::group([
    'middleware' => 'auth:sanctum'
], function ($router) {
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}/update', [UserController::class, 'update']);
    Route::delete('/{user}/delete', [UserController::class, 'destroy']);
    Route::post('/{user}/follow', [UserFollowController::class, 'follow']);
    Route::post('/{user}/unfollow', [UserFollowController::class, 'unfollow']);
    Route::get('/{user}/posts', [UserController::class, 'getUserPosts']);
    Route::get('/posts/saved', [UserController::class, 'getPostsSaved']);
    Route::get('/{user}/groups/preview', [GroupUserPivotController::class, 'getGroupsPreview']);
    Route::get('/{user}/groups', [GroupUserPivotController::class, 'getGroups']);
});
