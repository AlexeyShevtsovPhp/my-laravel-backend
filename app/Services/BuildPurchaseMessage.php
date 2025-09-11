<?php

namespace App\Services;

use App\Models\Good;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BuildPurchaseMessage
{
    /**
     * @param User $user
     * @param Collection<int, Good> $cartItems
     * @return string
     */
    public function buildPurchaseMessage(User $user, Collection $cartItems): string
    {
        $message = "Здравствуйте, {$user->name}, спасибо за вашу покупку.\n\n";
        $message .= "Список приобретенных товаров:\n";

        $totalSum = 0;

        foreach ($cartItems as $good) {
            /** @var Pivot&object{quantity: int} $pivot */
            $pivot = $good->pivot;

            $quantity = $pivot->quantity;
            $price = $good->price;
            $lineSum = $price * $quantity;

            $message .= "{$good->name} x{$quantity} = {$lineSum}₽\n";
            $totalSum += $lineSum;
        }

        $message .= "\nИтог к оплате: {$totalSum}₽";

        return $message;
    }
}
