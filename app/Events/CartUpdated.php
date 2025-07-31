<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CartUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $userId;
    public $totalQuantity;

    public function __construct(User $user, $totalQuantity)
    {
        $this->userId = $user->id;
        $this->totalQuantity = $totalQuantity;
    }

    public function broadcastOn()
    {
        return new Channel('cart.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'cart.updated';
    }
}
