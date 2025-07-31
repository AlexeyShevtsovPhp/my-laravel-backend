<?php

use App\Models\Good;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @var string $name
 * @var string $user
 * @var string $path
 * @var object $comments
 * @var LengthAwarePaginator<Good> $goods
 */
?>
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Аккаунт</title>
    <link rel="stylesheet" href="/css/cart.css">
</head>
<body>

<div class="logout">
    <a href="/monolit/categories/1" class="logout-style">
        <img src="/images/interface/back.png" alt="Выйти из аккаунта" class="logout-icon">
    </a>
</div>

<div class="greetings">
    <a href="{{"/monolit/users/$user->id?type=comments&page=1"}}">
        <img src=<?= $path ?> alt="Аватар" class="avatar" style="transform: scaleX(-1);" alt="none">
        <?= $username = $user->name ?>
    </a>
</div>

<span id = "cart-sign"><?= "Корзина" ?></span>


<table id="cart">
    <thead>
    <tr>
        <th>Название</th>
        <th>Цена</th>
        <th>Количество</th>
        <th style="width: 25px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($goods as $cartItem)
        <tr data-id="{{ $cartItem->id }}">
            <td>{{ $cartItem->name }}</td>
            <td>{{ $cartItem->price * $cartItem->pivot->quantity }}p</td>
            <td class="quantity">{{$cartItem->pivot->quantity}}</td>
            <td><button class = "small-button">-</button></td>
        </tr>
    @endforeach
    </tbody>
</table>
<label>Итог: {{$totalSum}}p</label>

<a href="{{"/monolit/users/$user->id?type=order&page=1"}}"><button class = "purchase">Оплатить</button></a>
<div class="button-container">
    <a href="<?= $goods->previousPageUrl() ?>" <?= $goods->currentPage() <= 1 ? 'class="disabled"' : '' ?>>
        <button class="<?= $goods->currentPage() > 1 ? 'previous-page' : 'disabled' ?>">
            <img src="/images/interface/back.png"
                 alt="Выйти из аккаунта"
                 class="left-arrow">
        </button>
    </a>
    <a href="<?= $goods->nextPageUrl() ?>" <?= !$goods->hasMorePages() ? 'class="disabled"' : '' ?>>
        <button class="<?= $goods->hasMorePages() ? 'next-page' : 'disabled' ?>">
            <img src="/images/interface/back.png"
                 alt="Выйти из аккаунта"
                 class="right-arrow"
                 style="transform: scaleX(-1)">
        </button>
    </a>
</div>

</body>
<script src="/js/DeleteFromshopCart.js" defer></script>
</html>
