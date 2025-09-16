<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CartUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public int $userId;

    public int $totalQuantity;

    /**
     * @param int $userId
     * @param int $totalQuantity
     */
    public function __construct(int $userId, int $totalQuantity)
    {
        $this->userId = $userId;
        $this->totalQuantity = $totalQuantity;
    }

    /**
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('cart.' . $this->userId);
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'cart.updated';
    }
}
