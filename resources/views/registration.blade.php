<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/css/index-auth.css">
</head>
<body>

<div class="notification" id="notification">Пользователь был успешно зарегистрирован!</div>
<div class="notification-taken-name" id="notification-taken-name">Данное имя уже занято</div>
<div class="notification-wrong" id="notification-wrong">Неверное имя пользователя или пароль</div>

<div class="form-container registration">
    <h2>Регистрация</h2>
    <form method="POST" class="registration" action="/registration">
        @csrf
        <div class="form-group">
            <label for="username">Имя пользователя:</label>
            <label for="username_reg"></label><input type="text" name="name" id="username_reg">
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <label for="password_reg"></label><input type="password" name="password" id="password_reg">
        </div>
        <button type="submit">Зарегистрироваться</button>
    </form>
</div>
<div class="auth-link">
    <a href="/login" class="auth-link-style">Авторизация</a>
</div>
<script src="/js/urlParam.js" defer></script>
</body>
</html>
