<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подтверждение покупки</title>
</head>
<body>
<p>Здравствуйте, {{ $user->name }}, спасибо за вашу покупку.</p>

<p>Список приобретенных товаров:</p>
<ul>
    @php $totalSum = 0; @endphp

    @foreach($cartItems as $good)
        @php $totalSum += $good->price * $good->pivot->quantity; @endphp

        <li>{{ $good->name }} x {{ $good->pivot->quantity }} = {{ $good->price * $good->pivot->quantity }}₽</li>

    @endforeach
</ul>

<p><strong>Итог к оплате: {{ $totalSum }}₽</strong></p>
</body>
</html>
