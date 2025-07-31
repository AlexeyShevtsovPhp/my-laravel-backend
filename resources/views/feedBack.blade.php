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
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Аккаунт</title>
    <link rel="stylesheet" href="/css/feedBack.css">
</head>
<body>
<input type="hidden" id="user_id" value="{{$user->id}}">

<div class="back">
    <a href="/categories/1?page=1" class="back-style">
        <img src="/images/interface/back.png" alt="Выйти из аккаунта" class="back-icon">
    </a>
</div>

<div class="greetings">
    <a href={{"/users/$user->id?page=1"}}>
        <img src=<?= $path ?> alt="Аватар" class="avatar" style="transform: scaleX(-1);" alt="none">
        <?= $username = $user->name; ?>
    </a>
</div>

<label class="e-mail-info-1">Оставьте свой отзыв или задайте вопрос на интересующую вас тему.</label>
<label class="e-mail-info-2">Наш ответ поступит вам на почту в течение 3 рабочих дней.</label>
<form class="feedBack-container" action="/e-mail" method="POST" id="feedBack-form">
    @csrf
    <input type="hidden" id="name" name="name" value=""/>

    <div class="form-message">
        <input id="subject" name="message" placeholder="Введите тему сообщения">
        <textarea id="message" name="message" placeholder="Введите ваш комментарий"></textarea>
    </div>
    <div class="form-submit">
        <button id="submit-button" type="submit">Отправить</button>
    </div>
</form>

</body>
</html>
