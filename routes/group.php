<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupAdminController;
use App\Http\Controllers\GroupUserPivotController;

// Group
Route::get('/groups', [GroupController::class, 'getGroups'])->middleware('api');
Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'group'
], function ($router) {
    Route::get('/{group}', [GroupController::class , 'show']);
    Route::get('/{group}/name', [GroupController::class , 'getGroupName']);
    Route::get('/{group}/posts', [GroupController::class , 'getGroupPosts']);
    Route::post('/create', [GroupController::class , 'store']);
    Route::put('/{group}/update',[GroupController::class , 'update']);
    Route::delete('/{group}/delete', [GroupAdminController::class , 'destroy']);
    Route::post('/{group}/join', [GroupUserPivotController::class, 'join']);
    Route::delete('/{group}/leave', [GroupUserPivotController::class, 'leave']);
    Route::delete('/{group}/{post}/delete', [GroupAdminController::class, 'deletePost']);
    Route::post('/{group}/{user}/add', [GroupAdminController::class, 'addMember']);
    Route::delete('/{group}/{user}/kick', [GroupAdminController::class, 'kickUser']);
    Route::post('/{group}/{user}/make-moderator', [GroupAdminController::class, 'makeModerator']);
    Route::post('/{group}/{user}/remove-moderator', [GroupAdminController::class, 'removeModerator']);
    Route::post('/{group}/{user}/make-admin', [GroupAdminController::class, 'makeAdmin']);
    Route::post('/{group}/{user}/remove-admin', [GroupAdminController::class, 'removeAdmin']);
});
