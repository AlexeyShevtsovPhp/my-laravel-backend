@php use Illuminate\Pagination\LengthAwarePaginator; @endphp
<?php
/**
 * @var string $name
 * @var string $date
 * @var string $role
 * @var string $rights
 * @var LengthAwarePaginator $user
 */
?>
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Аккаунт</title>
    <link rel="stylesheet" href="/css/account.css">
</head>
<body>
<input type="hidden" id="user_id" value="{{$user->id}}">
<div class="logout">
    <a href="/users/" class="logout-style">
        <img src="/images/interface/back.png" alt="Выйти из аккаунта" class="logout-icon">
    </a>
</div>

<?php
$path = '';
switch ($role) {
    case 'admin':
        $path = '/images/userIcon/admin.png';

        break;
    case 'guest':
        $path = '/images/userIcon/guest.png';

        break;
    default:
        $path = '/images/userIcon/user.png';
}
?>
<img class="person-img" src="<?= $path ?>" alt="Аватар" style="transform: scaleX(-1);">

<span><?= $name ?></span>

<ul>
    <li><strong>Должность:</strong> <?= $role ?></li>
    <li><strong>Дата регистрации:</strong> <?= $date ?></li>
</ul>

<p>Ваши комментарии:</p>
<div id='AccountComments'>
    <table>
        <thead>
        <tr>
            <th>Комментарии</th>
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

<a href='/logout'>
    <button class="exitButton">Выйти</button>
</a>
<script src="/js/allUserComments.js" defer></script>
</body>
</html>
