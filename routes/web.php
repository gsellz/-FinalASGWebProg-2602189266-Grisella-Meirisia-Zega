<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;

Route::get('/', function () {
    return view('template');
});

Route::post('/register', [AuthenticationController::class, 'register'])->name('user.register');
Route::get('/register', [AuthenticationController::class, 'indexRegister'])->name('user.register.show');

Route::post('/login', [AuthenticationController::class, 'authenticate'])->name('user.login');
Route::get('/login', [AuthenticationController::class, 'indexLogin'])->name('user.login.show');

Route::resource('/user', UserController::class);

Route::post('/payment-process', [PaymentController::class, 'payment'])->name('user.payment.process');
Route::get('/payment', [PaymentController::class, 'index'])->name('user.payment.show');
Route::post('/payment-over', [PaymentController::class, 'handleOverPayment'])->name('user.payment.over');

Route::middleware(['auth', 'check.payment.status'])->group(function () {
    Route::get('/homepage', [UserController::class, 'home'])->name('user.homepage');

    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('user.logout');

    Route::resource('/friends', FriendController::class);
    Route::resource('/friends-request', FriendRequestController::class);

    Route::post('/friend-request/handle', [FriendRequestController::class, 'handleRequest'])->name('friends-request.handle');

    Route::get('/search', [UserController::class, 'search'])->name('search');

    Route::get('/message/{user_id}', [MessageController::class, 'index'])->name('message');
    Route::post('/message/{user_id}', [MessageController::class, 'store'])->name('message.send');

    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');

});
