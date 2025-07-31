<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ChatUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $userId;
    public $comment;
    public $username;

    public function __construct(User $user, Comment $comment)
    {
        $this->userId = $user->id;
        $this->comment = $comment;
        $this->username = $user->name;
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'chat.updated';
    }
}
