<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'messages'
], function ($router) {
    Route::get('/{user}/all', [MessageController::class, 'index']);
    Route::get('/chat-list', [MessageController::class, 'getChatList']);
    Route::post('/{user}/create', [MessageController::class, 'create']);
    Route::post('/{user}/mark-last-seen', [MessageController::class, 'markLastSeen']);
});
