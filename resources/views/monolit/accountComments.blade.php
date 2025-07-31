<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @var string $name
 * @var string $date
 * @var string $role
 * @var string $rights
 * @var string $user
 * @var string $tableName
 * @var object $comments
 * @var object $allGoods
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

use App\Models\Comment;

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

<div class="goods">
    <a href="{{"/monolit/users/$user->id?type=order&page=1"}}" class="logout-style">
        Заказ ({{count($allGoods)}})
    </a>
</div>

<div id='AccountComments'>
    <table>
        <thead>
        <tr>
            <th>{{$tableName}}</th>
        </tr>
        </thead>
        <tbody>
        @if($comments->isEmpty())
        <tr><td colspan="3">Пусто</td></tr>
        @else
            @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->content }}</td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

<div class="button-container">
    <a href="?type=comments&<?= parse_url($comments->previousPageUrl(), PHP_URL_QUERY) ?>"
        <?= $comments->currentPage() <= 1 ? 'class="disabled"' : '' ?>>
        <button class="<?= $comments->currentPage() > 1 ? 'previous-page' : 'disabled' ?>">
            <img src="/images/interface/back.png"
                 alt="Назад"
                 class="left-arrow">
        </button>
    </a>

    <a href="?type=comments&{{ parse_url($comments->nextPageUrl(), PHP_URL_QUERY) }}"
       class="{{ !$comments->hasMorePages() ? 'disabled' : '' }}">
        <button class="{{ $comments->hasMorePages() ? 'next-page' : 'disabled' }}">
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
