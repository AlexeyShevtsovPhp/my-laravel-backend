<?php

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Feedback;
use App\Http\Controllers\Monolit\Cart;
use App\Http\Controllers\Monolit\Search;
use App\Http\Controllers\Monolit\User as MonolitUser;
use App\Http\Controllers\Monolit\Feedback as MonolitFeedback;
use App\Http\Controllers\Monolit\Account as MonolitAccount;
use App\Http\Controllers\Monolit\Categories;
use App\Http\Controllers\Monolit\Comments;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authorization;
use App\Http\Controllers\Registration;
use App\Http\Controllers\Category;
use App\Http\Controllers\Logout;
use App\Http\Controllers\Account;
use App\Http\Controllers\User;
use App\Http\Controllers\Api\Category as ApiCategories;
use App\Http\Controllers\Api\Authorization as ApiAuthorization;
use App\Http\Controllers\Api\RegistrationApiController as ApiRegistration;
use App\Http\Controllers\Api\User as ApiUser;
use App\Http\Controllers\Api\Comments as ApiComments;
use App\Events\MessageSent;
use App\Http\Controllers\ChatController;

Route::get('/login', [Authorization::class, 'load'])
    ->name('login');

Route::post('/login', [ApiAuthorization::class, 'enter']);

Route::get('/registration', [Registration::class, 'load']);

Route::post('/registration', [ApiRegistration::class, 'create']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/feedback', [Feedback::class, 'index']);

    Route::post('/e-mail', [Feedback::class, 'send']);

    Route::get('/categories/{categoryId}', [Category::class, 'show']);

    Route::get('/categories/', [Category::class, 'index']);

    Route::group(['middleware' => 'cors'], function () {

        Route::get('/account', [Account::class, 'load']);
    });
    Route::get('/logout', [Logout::class, 'logout']);

    Route::get('/users/{user}', [User::class, 'show'])
        ->middleware('auth');

    Route::group(['prefix' => 'monolit'], function () {

        Route::get('/find', [Search::class, 'index']);

        Route::get('/order/{user}', [MonolitAccount::class, 'show']);

        Route::get('/categories/{category}', [Categories::class, 'show']);

        Route::get('/categories/{comment_id}', [Categories::class, 'show']);

        Route::post('/categories/{category_id}', [Comments::class, 'create']);

        Route::get('/users/{user}', [MonolitUser::class, 'show']);

        Route::get('/cart/{user}', [Cart::class, 'show']);

        Route::post('/cart/add', [Cart::class, 'create']);

        Route::delete('/comments/delete', [ApiComments::class, 'delete'])
            ->middleware('user');

        Route::get('/feedback', [MonolitFeedback::class, 'index']);

        Route::delete('/cart/delete', [Cart::class, 'delete']);

        Route::get('/users/', [MonolitUser::class, 'index'])
            ->middleware('admin');
    });

    Route::get('/users/', [User::class, 'index'])
        ->middleware('admin');});


Route::post('/send-message', [ChatController::class, 'send']);
