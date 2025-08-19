<?php

use App\Http\Controllers\Api\AllCartPage;
use App\Http\Controllers\Api\AllUserCart;
use App\Http\Controllers\Api\AllUserComments;
use App\Http\Controllers\Api\Cart;
use App\Http\Controllers\Api\CategoryManage;
use App\Http\Controllers\Api\CommentManage;
use App\Http\Controllers\Api\CreateGood;
use App\Http\Controllers\Api\Feedback;
use App\Http\Controllers\Api\GoodManage;
use App\Http\Controllers\Api\Like;
use App\Http\Controllers\Api\Radar;
use App\Http\Controllers\Api\Registration;
use App\Http\Controllers\Api\UserCategoryInfo;
use App\Http\Controllers\Api\UserManage;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/comments/user/{userId}', [CommentManage::class, 'show']);
    Route::post('/comments', [CommentManage::class, 'create']);
    Route::delete('/comments/{comment}', [CommentManage::class, 'delete']);

    Route::post('/cart', [Cart::class, 'add']);
    Route::post('/cart/clear', [Cart::class, 'clear']);
    Route::delete('/cart/{product_id}', [Cart::class, 'delete']);

    Route::post('/feedback', [Feedback::class, 'send']);
    Route::post('/buy', [Feedback::class, 'get']);

    Route::post('/goods/like/{good}', [Like::class, 'toggleLike']);

    Route::get('/users', [UserManage::class, 'index'])->middleware(['auth:sanctum', 'admin']);
    Route::delete('/user/{user}', [UserManage::class, 'delete'])->middleware(['auth:sanctum', 'admin']);
    Route::get('/userCategoryInfo/{user}', [UserCategoryInfo::class, 'info'])->middleware(['auth:sanctum', 'admin']);

    Route::post('/create', [CreateGood::class, 'create'])->middleware(['auth:sanctum', 'admin']);
    Route::put('/change/{good}', [CreateGood::class, 'change'])->middleware(['auth:sanctum', 'admin']);

    Route::get('/goods/{category_id}', [GoodManage::class, 'show']);

    Route::middleware('auth:sanctum')->get('/cartPage/{user}', [AllCartPage::class, 'info']);
    Route::middleware('auth:sanctum')->get('/users/{user}', [AllUserComments::class, 'info']);
    Route::middleware('auth:sanctum')->get('/cart/{user}', [AllUserCart::class, 'info']);
});

Route::post('/register', [Registration::class, 'create']);

Route::post('/login', [UserManage::class, 'login']);

Route::get('/categories', [CategoryManage::class, 'index']);

Route::get('/comments', [CommentManage::class, 'read']);

Route::get('/comments/user/{userId}', [CommentManage::class, 'show']);

Route::get('/search', [Radar::class, 'load']);
