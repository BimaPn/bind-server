<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'notifications'
], function ($router) {
    Route::get('/get', [NotificationController::class, 'index']);
    Route::get('/unread-count', [NotificationController::class, 'notificationUnreadCount']);
});
