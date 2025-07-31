<?php

use App\Models\Comment;
use App\Models\Good;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @var string $name
 * @var string $date
 * @var string $role
 * @var string $rights
 * @var string $user
 * @var string $tableName
 * @var object $allComments
 * @var LengthAwarePaginator<Good> $goods
 * @var LengthAwarePaginator<Comment> $comments
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
<div class="logout">
    <a href="/monolit/users/" class="logout-style">
        <img src="/images/interface/back.png" alt="Выйти" class="logout-icon">
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

<div class="comments">
    <a href="{{"/monolit/users/$user->id?type=comments&page=1"}}" class="logout-style">
        Комментарии ({{count($allComments)}})
    </a>
</div>

<div id='AccountComments'>
    <table>
        <thead>
        <tr>
            <th>{{$tableName}}</th>
            <th style="width: 62px;">Кол-во</th>
        </tr>
        </thead>
        <tbody>
        @if($goods->isEmpty())
            <tr>
                <td colspan="3">Пусто</td>
            </tr>
        @else
            @foreach($goods as $good)
                <tr>
                    <td>{{$good->name}}</td>
                    <td style="text-align: center;">{{ $good->pivot->quantity}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

<div class="button-container">
    <a href="?type=order&<?= parse_url($goods->previousPageUrl(), PHP_URL_QUERY) ?>"
        <?= $goods->currentPage() <= 1 ? 'class="disabled"' : '' ?>>
        <button class="<?= $goods->currentPage() > 1 ? 'previous-page' : 'disabled' ?>">
            <img src="/images/interface/back.png"
                 alt="Назад"
                 class="left-arrow">
        </button>
    </a>

    <a href="?type=order&<?= parse_url($goods->nextPageUrl(), PHP_URL_QUERY) ?>"
        <?= !$goods->hasMorePages() ? 'class="disabled"' : '' ?>>
        <button class="<?= $goods->hasMorePages() ? 'next-page' : 'disabled' ?>">
            <img src="/images/interface/back.png"
                 alt="Вперёд"
                 class="right-arrow"
                 style="transform: scaleX(-1)">
        </button>
    </a>

</div>

<a href='/logout'>
    <button class="exitButton">Выйти</button>
</a>

</body>
</html>
