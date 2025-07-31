<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('cart.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
