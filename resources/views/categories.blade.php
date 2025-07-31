<?php

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @var User $user
 * @var string $button
 * @var string $path
 * @var LengthAwarePaginator $category
 */
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Категории</title>
    <link rel="stylesheet" href="/css/index-category.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<input type="hidden" id="category_id" value="{{$category->id}}">
<div class="greetings">
    <a href={{"/users/$user->id?page=1"}}>
        <img src=<?= $path ?> alt="Аватар" class="avatar" style="transform: scaleX(-1);" alt="none">
        <?= $username = $user->name; ?>
    </a>
</div>

<div class="logout">
    <a href="/logout" class="logout-style">
        <img src="/images/interface/logout.png" alt="Выйти из аккаунта" class="logout-icon">
    </a>
</div>

<div class="monolit">
    <a href="/monolit/categories/1?page=1" class="logout-style">
        Монолит
    </a>
</div>

<div class="e-mail">
    <a href="/feedback" class="logout-style">
        Свяжись с нами
    </a>
</div>

<div class="table-container category-table">
    <img src="/images/interface/eye.png" alt="Око" class="eye">
    <table>
        <thead>
        <tr>
            <th>Категории</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="table-container comments-table" id='comments'>
    <label class="category-name">{{ $category_name ?? '' }}</label>
    <table>
        <thead>
        <tr>
            <th>Имя</th>
            <th>Комментарий</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<form class="table-container" id="first-form" action="/controllers/comments/" method="POST" id="form">
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

<button id="userList"
    <?= $button == 'active' ? 'class="users"' : 'style="visibility: hidden; pointer-events: none;"' ?>>
    Список пользователей
</button>

<div class="button-container">
    <button class="previous-page" id="prevButton">
        <img src="/images/interface/back.png"
             alt="Выйти из аккаунта"
             class="left-arrow"></button>

    <button class="next-page" id="nextButton">
        <img src="/images/interface/back.png"
             alt="Выйти из аккаунта"
             class="right-arrow"
             style="transform: scaleX(-1)"></button>
</div>

<script src="/js/categories.js" defer></script>

</body>
</html>
