<?php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\TestNotificationController;
use App\Notifications\ClientApprovedNotification;

Route::post('/managers', [ManagerController::class, 'store'])->name('managers.store');

Route::get('/notifications', function () {
    $user = User::orderBy('id', 'desc')->first(); // Get the last registered user

    return response()->json([
        'unread' => $user->unreadNotifications,
        'all' => $user->notifications
    ]);
});
