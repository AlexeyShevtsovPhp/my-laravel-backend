@php use App\Models\User;use Illuminate\Pagination\LengthAwarePaginator; @endphp
<?php
/**
 * @var string $username
 * @var string $role
 * @var string $path
 * @var LengthAwarePaginator<User> $users
 */
?>
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список пользователей</title>
    <link rel="stylesheet" href="/css/MonolituserList.css">

</head>
<body>

<div class="logout">
    <a href="/monolit/categories/1" class="logout-style">
        <img src="/images/interface/back.png" alt="Выйти" class="logout-icon">
    </a>
</div>

<div class="table-container" id="UserTable">
    <img src="/images/interface/eye.png" alt="Выйти из аккаунта" class="eye">
    <table>
        <thead>
        <tr>
            <th>Пользователи</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>
                    <a class="users" href={{"/monolit/users/$user->id?type=comments&page=1"}}>
                        {{ $user->name }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="button-container">
    <a id="placeholder"
       href="<?= $users->previousPageUrl() ?>" <?= $users->currentPage() <= 1 ? 'class="disabled"' : '' ?>>
        <button class="<?= $users->currentPage() > 1 ? 'previous-page' : 'disabled' ?>">
            <img src="/images/interface/back.png"
                 alt="Выйти из аккаунта"
                 class="left-arrow">
        </button>
    </a>
    <a id="placeholder" href="<?= $users->nextPageUrl() ?>" <?= !$users->hasMorePages() ? 'class="disabled"' : '' ?>>
        <button class="<?= $users->hasMorePages() ? 'next-page' : 'disabled' ?>">
            <img src="/images/interface/back.png"
                 alt="Выйти из аккаунта"
                 class="right-arrow"
                 style="transform: scaleX(-1)">
        </button>
    </a>
</div>
</body>
</html>
