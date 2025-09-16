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
    @php
        $totalSum = 0;
    @endphp

    @foreach($cartItems as $good)
        @php
            $quantity = $good->pivot->quantity;
            $lineSum = $good->price * $quantity;
            $totalSum += $lineSum;
        @endphp

        <li>{{ $good->name }} x{{ $quantity }} = {{ $lineSum }}₽</li>
    @endforeach
</ul>

<p><strong>Итог к оплате: {{ $totalSum }}₽</strong></p>
</body>
</html>
