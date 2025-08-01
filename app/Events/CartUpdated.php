<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CartUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public int $userId;
    public int $totalQuantity;

    /**
     * @param User $user
     * @param int $totalQuantity
     */
    public function __construct(User $user, int $totalQuantity)
    {
        $this->userId = $user->id;
        $this->totalQuantity = $totalQuantity;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('cart.' . $this->userId);
    }

    public function broadcastAs(): string
    {
        return 'cart.updated';
    }
}
