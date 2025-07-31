<?php
/**
 * @var string $username
 * @var string $role
 * @var string $path
 */
?>
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список пользователей</title>
    <link rel="stylesheet" href="/css/userList.css">

</head>
<body>

<div class="table-container" id="UserTable">
    <img src="/images/interface/eye.png" alt="Выйти из аккаунта" class="eye">
    <table>
        <thead>
        <tr>
            <th>Пользователи</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

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

<button class=userList id="userList">
    Список категорий
</button>


<script src="/js/userList.js" defer></script>
</body>
</html>
