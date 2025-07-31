<?php

use App\Models\Comment;
use App\Models\Goods;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @var User $user
 * @var string $button
 * @var string $path
 * @var object $categories
 * @var object $goods
 * @var object $allGoods
 * @var LengthAwarePaginator<Comment> $comments
 */
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Категории</title>
    <link rel="stylesheet" href="/css/categoriesMonolit.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.9/dist/css/autoComplete.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

{{--<span class = "countGoods">{{ $allGoods->count() }}</span>--}}
<div class = "cartIcon">
    <a href="{{"/monolit/cart/$user->id?page=1"}}">
        <img src="/images/interface/cart.png" class="cart" alt="Корзина">
    </a>
</div>

<div class="greetings">
    <a href="{{"/monolit/users/$user->id?type=comments&page=1"}}">
        <img src=<?= $path ?> alt="Аватар" class="avatar" style="transform: scaleX(-1);" alt="none">
        <?= $username = $user->name ?>
    </a>
</div>

<div class="logout">
    <a href="/logout" class="logout-style">
        <img src="/images/interface/logout.png" alt="Выйти из аккаунта" class="logout-icon">
    </a>
</div>

<div class="monolit">
    <a href="/categories/1?page=1" class="logout-style">
        Обратно
    </a>
</div>

<div class="e-mail">
    <a href="/monolit/feedback" class="logout-style">
        Свяжись с нами
    </a>
</div>

<div class="table-container category-table">
    <img src="/images/interface/eye.png" alt="Выйти из аккаунта" class="eye">
    <table>
        <thead>
        <tr>
            <th>Категории</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>
                    <a class="categories" href={{"/monolit/categories/$category->id"}} >
                        {{ $category->name }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="autoComplete_wrapper" id="search">
        <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocomplete="off" autocapitalize="off">
    </div>

</div>
<div class="comments-table" id='comments'>
    <label class="category-name">{{ $categorySelected->name ?? '' }}</label>
    <table id ="goods">
        <thead>
        <tr>
            <th>Товары</th>
            <th>Цена</th>
            <th style="width: 25px"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($goods as $good)
            <tr data-id="{{ $good->id }}">
                <td>{{$good->name }}</td>
                <td>{{$good->price }}p</td>
                <td><button class = "small-button">+</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table class="comments-table" id='usersComments'>
        <thead>
        <tr>
            <th>Имя</th>
            <th>Комментарий</th>
            <th style="width: 25px"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr data-id="{{ $comment->id }}">
                <td>{{ $comment->user->name}}</td>
                <td>{{ $comment->content}}</td>
                <td><button class = "small-comment-button">-</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div>
    </div>
</div>
<form class="table-container" id="first-form" action="{{ url('/monolit/categories/' . ($categorySelected->id ?? 1)) }}"
      method="POST">
    @csrf
    <input type="hidden" id="name" name="name" value=""/>

    <div class="form-message">
        <label for="message"></label>
        <textarea id="message" name="message" placeholder="Введите ваш комментарий"></textarea>
    </div>
    <div class="form-submit">
        <button id="submit-button" type="submit">Принять</button>
    </div>
</form>

<a href="/monolit/users/">
    <button id="userList"
        <?= $button == 'active' ? 'class="users"' : 'style="visibility: hidden; pointer-events: none;"' ?>>
        Список пользователей
    </button>
</a>

<div class="button-container">
    <a href="<?= $comments->previousPageUrl() ?>" <?= $comments->currentPage() <= 1 ? 'class="disabled"' : '' ?>>
        <button class="<?= $comments->currentPage() > 1 ? 'previous-page' : 'disabled' ?>">
            <img src="/images/interface/back.png"
                 alt="Выйти из аккаунта"
                 class="left-arrow">
        </button>
    </a>
    <a href="<?= $comments->nextPageUrl() ?>" <?= !$comments->hasMorePages() ? 'class="disabled"' : '' ?>>
        <button class="<?= $comments->hasMorePages() ? 'next-page' : 'disabled' ?>">
            <img src="/images/interface/back.png"
                 alt="Выйти из аккаунта"
                 class="right-arrow"
                 style="transform: scaleX(-1)">
        </button>
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.9/dist/autoComplete.min.js"></script>
<script src="/js/autoComplete.js" defer></script>
<script src="/js/shopCart.js" defer></script>
<script src="/js/DeleteFromMonolitComments.js" defer></script>
</body>
</html>
