<?php

use App\Events\FriendRequest;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Broadcast::routes(["prefix" => "api",'middleware' => ['auth:sanctum']]);

Route::post('/testing', function() {
    FriendRequest::dispatch("hahah bitch");
    return response()->json([
        "message" => "done babyyyy....."
    ]);
});

require __DIR__.'/auth.php';
require __DIR__.'/group.php';
require __DIR__.'/post.php';
require __DIR__.'/user.php';
require __DIR__.'/message.php';
require __DIR__.'/notification.php';
