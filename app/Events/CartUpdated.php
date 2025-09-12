<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

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
    /**
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('cart.'.$this->userId);
    }
    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'cart.updated';
    }
}
