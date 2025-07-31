<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/css/index-auth.css">
</head>
<body>

<div class="notification-wrong" id="notification-wrong">Неверное имя пользователя или пароль</div>

<div class="form-container authorization">
    <h2>Авторизация</h2>
    <form method="POST" class="authorization" action="/login">
        @csrf
        <div class="form-group">
            <label for="username">Имя пользователя:</label>
            <label for="username_auth"></label><input type="text" name="user" id="username_auth">
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <label for="password_auth"></label><input type="password" name="password" id="password_auth">
        </div>
        <button type="submit">Войти</button>
    </form>
</div>
<div class="auth-link-reg">
    <a href="/registration" class="auth-link-style-reg">Регистрация</a>
</div>
<script src="/js/urlParam.js" defer></script>
</body>
</html>
