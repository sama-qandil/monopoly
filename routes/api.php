<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;

//بتعرفني اليوزر اللي موجود اللوقتي عن طريق التوكن بتاعه من غير ما احتاج بيانات منه
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/link-account', [AuthController::class, 'LinkAccount']);
});



Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('store')->group(function () {
        
        Route::get('/category/{category}', [App\Http\Controllers\StoreController::class, 'getitemByCategory']);
        Route::get('/item/{category}/{id}', [App\Http\Controllers\StoreController::class, 'getitemDetails']);

        Route::prefix('buy')->group(function () {
            Route::post('/character/{id}', [App\Http\Controllers\StoreController::class, 'buyCharacter']);
            Route::post('/dice/{id}', [App\Http\Controllers\StoreController::class, 'buyDice']);
            Route::post('/necklace/{id}', [App\Http\Controllers\StoreController::class, 'buyNecklaces']);
            Route::post('/gold/{id}', [App\Http\Controllers\StoreController::class, 'buyGold']);
            Route::post('/jewelry/{id}', [App\Http\Controllers\StoreController::class, 'buyJewelry']);
        });
    });
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks/{type}', [App\Http\Controllers\TaskController::class, 'index']);
    Route::post('/tasks/{taskId}/collect', [App\Http\Controllers\TaskController::class, 'collect']);
}); 

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile']);
});


Route::middleware('auth:sanctum')->group(function () {
Route::post('/send-friend-invite', [App\Http\Controllers\FriendInviteController::class, 'sendfriendinvites']);
Route::post('/friends-invite/{senderId}/accept', [App\Http\Controllers\FriendInviteController::class, 'Acceptinvite']);
Route::post('/friends-invite/{senderId}/decline', [App\Http\Controllers\FriendInviteController::class, 'Declineinvite']);

});


Route::middleware('auth:sanctum')->group(function () {
Route::post('/send-system-message', [App\Http\Controllers\SystemMessageController::class, 'index']);
Route::post('/messages/{id}/mark-as-read', [App\Http\Controllers\SystemMessageController::class, 'markAsRead']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/buy-slot/{slotId}', [App\Http\Controllers\NecklaceSlotController::class, 'buySlot']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/event', [App\Http\Controllers\EventController::class, 'getActiveEvents']);
    Route::post('/event/{id}/buy-prize', [App\Http\Controllers\EventController::class, 'buyPrize']);

});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/equipNecklace', [App\Http\Controllers\EquippedNecklaceController::class, 'equip']);
});
