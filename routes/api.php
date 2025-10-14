<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AllCartPageController;
use App\Http\Controllers\Api\AllUserCartController;
use App\Http\Controllers\Api\AllUserCommentsController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryManageController;
use App\Http\Controllers\Api\CommentManageController;
use App\Http\Controllers\Api\CreateGoodController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\GoodManageController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\RadarController;
use App\Http\Controllers\Api\RatingGoodsController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\UserCategoryInfoController;
use App\Http\Controllers\Api\UserManageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/comments/user/{userId}', [CommentManageController::class, 'read']);
    Route::post('/comments', [CommentManageController::class, 'create']);
    Route::delete('/comments/{comment}', [CommentManageController::class, 'delete'])->middleware('can.modify.comment');

    Route::post('/cart', [CartController::class, 'add']);
    Route::post('/cart/clear', [CartController::class, 'clear']);
    Route::delete('/cart/{product_id}', [CartController::class, 'delete']);

    Route::post('/feedback', [FeedbackController::class, 'send']);
    Route::post('/buy', [FeedbackController::class, 'buy']);

    Route::post('/rate', [RatingGoodsController::class, 'rate']);

    Route::post('/goods/like/{good}', [LikeController::class, 'toggleLike']);

    Route::get('/users', [UserManageController::class, 'index'])->middleware(['auth:sanctum', 'admin']);
    Route::delete('/user/{user}', [UserManageController::class, 'delete'])->middleware(['auth:sanctum', 'admin']);
    Route::get('/userCategoryInfo/{user}', [UserCategoryInfoController::class, 'info']);

    Route::post('/create', [CreateGoodController::class, 'create'])->middleware(['auth:sanctum', 'admin']);
    Route::put('/change/{good}', [CreateGoodController::class, 'change'])->middleware(['auth:sanctum', 'admin']);

    Route::get('/goods/{category_id}', [GoodManageController::class, 'show']);
    Route::get('/goodInfo/{good}', [GoodManageController::class, 'info']);

    Route::get('/cartPage/{user}', [AllCartPageController::class, 'info'])->middleware('can.view.user.cart');
    Route::get('/users/{user}', [AllUserCommentsController::class, 'info'])->middleware('can.view.user.cart');
    Route::get('/cart/{user}', [AllUserCartController::class, 'info'])->middleware('can.view.user.cart');
});

Route::post('/register', [RegistrationController::class, 'create']);

Route::post('/login', [UserManageController::class, 'login']);

Route::get('/categories', [CategoryManageController::class, 'index']);

Route::get('/comments', [CommentManageController::class, 'read']);

Route::get('/comments/user/{userId}', [CommentManageController::class, 'read']);

Route::get('/search', [RadarController::class, 'load']);
