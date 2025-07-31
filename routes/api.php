<?php

use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CreateGoodApiController;
use App\Http\Controllers\Api\FeedbackApiController;
use App\Http\Controllers\Api\LikeApiController;
use App\Http\Controllers\Api\RadarApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\RegistrationApiController;
use App\Http\Controllers\Api\Category as ApiCategories;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\User as ApiUser;
use App\Http\Controllers\Api\GoodApiController;
use App\Http\Controllers\Api\UserInfoApiController;
use App\Http\Controllers\MessageController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/comments', [CommentApiController::class, 'create']);
    Route::delete('/comments/{comment}', [CommentApiController::class, 'delete']);
    Route::get('/cart/{user}', [CartApiController::class, 'show']);
    Route::get('/cart/all/{user}', [CartApiController::class, 'all']);
    Route::get('/comments/user/{userId}', [CommentApiController::class, 'show']);
    Route::delete('/cart/{product_id}', [CartApiController::class, 'delete']);
    Route::post('/cart', [CartApiController::class, 'create']);
    Route::post('/feedback', [FeedbackApiController::class, 'send']);
    Route::post('/buy', [FeedbackApiController::class, 'get']);
    Route::post('/goods/like/{good}', [LikeApiController::class, 'toggleLike']);
    Route::post('/cart/clear', [CartApiController::class, 'clearAll']);
    Route::get('/users', [ApiUser::class, 'index'])->middleware(['auth:sanctum', 'admin']);
    Route::delete('/user/{user}', [UserApiController::class, 'delete'])->middleware(['auth:sanctum', 'admin']);
    Route::post('/create', [CreateGoodApiController::class, 'create'])->middleware(['auth:sanctum', 'admin']);
    Route::put('/change/{good}', [CreateGoodApiController::class, 'change'])->middleware(['auth:sanctum', 'admin']);
    Route::get('/user', [UserApiController::class, 'currentUser']);
    Route::get('/users/{user}', [UserApiController::class, 'show'])->whereNumber('user');
    Route::get('/goods/{category_id}', [GoodApiController::class, 'show']);
    Route::middleware('auth:sanctum')->get('/users/{user}', [UserInfoApiController::class, 'show']);
});

Route::get('/comments', [CommentApiController::class, 'read']);

Route::post('/login', [UserApiController::class, 'login']);

Route::post('/register', [RegistrationApiController::class, 'create']);

Route::get('/categories', [ApiCategories::class, 'index']);

Route::get('/search', [RadarApiController::class, 'load']);

Route::get('/comments/user/{userId}', [CommentApiController::class, 'show']);

Route::post('/send-message', [MessageController::class, 'send']);







