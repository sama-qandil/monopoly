<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendInviteController;
use App\Http\Controllers\SystemMessageController;
use App\Http\Controllers\NecklaceSlotController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EquippedNecklaceController;


// بتعرفني اليوزر اللي موجود اللوقتي عن طريق التوكن بتاعه من غير ما احتاج بيانات منه
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('welcome', function () {
    return 'Welcome to the API';
});

Route::post('/device-login', [AuthController::class, 'deviceLogin']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user-profile', function (Request $request) {
//         return new \App\Http\Resources\UserResource($request->user());
//     });
// });

// TODO: group all middleware('auth:sanctum') under one group

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/link-account', [AuthController::class, 'LinkAccount']);




    Route::prefix('store')->group(function () {

        // TODO: NEVER use (App\Http\Controllers\StoreController) import namespace and use StoreController directly
        Route::get('/category/{category}', [StoreController::class, 'getItemsByCategory']);
        Route::get('/item/{shopItem}', [StoreController::class, 'getItemDetails']);
        Route::post('/buy/{shopItem}', [StoreController::class, 'buyItem']);

    
});


    Route::get('/tasks/{type}', [TaskController::class, 'index']);
    Route::post('/tasks/{task}/collect', [TaskController::class, 'collect']);
//
    Route::get('/profile', [UserController::class, 'profile']);
//
    Route::post('/send-friend-invite', [FriendInviteController::class, 'sendfriendinvites']);
    Route::post('/friends-invite/{senderId}/accept', [FriendInviteController::class, 'Acceptinvite']);
    Route::post('/friends-invite/{senderId}/decline', [FriendInviteController::class, 'Declineinvite']);
//
    Route::post('/send-system-message', [SystemMessageController::class, 'index']);
    Route::post('/messages/{id}/mark-as-read', [SystemMessageController::class, 'markAsRead']);
//
    Route::post('/buy-slot/{slotId}', [NecklaceSlotController::class, 'buySlot']);
//
    Route::post('/event', [EventController::class, 'getActiveEvents']);
    Route::post('/event/{id}/buy-prize', [EventController::class, 'buyPrize']);
//
    Route::post('/equipNecklace', [EquippedNecklaceController::class, 'equip']);
});
