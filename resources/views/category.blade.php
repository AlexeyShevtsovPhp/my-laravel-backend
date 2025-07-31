<?php
/**
 * @var string $username
 * @var string $path
 */
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Комментарии</title>
    <link rel="stylesheet" href="/css/index.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="greetings">
    <a href="/account">
        <img src=<?= $path ?> alt="Аватар" class="avatar" style="transform: scaleX(-1);" alt="none">
        <?= $username ?>
    </a>
</div>

<div class="logout">
    <a href="/categories/" class="logout-style">
        <img src="/images/interface/back.png" alt="Выйти из аккаунта" class="logout-icon">
    </a>
</div>

<div class="table-container">
    <table>
        <thead>
        <tr>
            <th>Имя</th>
            <th>Комментарий</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="button-container">
    <button class="previous-page" id="prevButton">Назад</button>
    <button class="next-page" id="nextButton">Вперёд</button>
</div>
<hr>

<form class="form-first" action="/controllers/comments/" method="POST" id="form">
    @csrf
    <input type="hidden" id="name" name="name" value=""/>

    <div class="form-message">
        <label for="message">Сообщение:</label>
        <textarea id="message" name="message"></textarea>
    </div>
    <div class="form-submit">
        <button id="submit-button" type="submit">Принять</button>
    </div>
</form>
<script src="/js/users.js" defer></script>
</body>
</html>
