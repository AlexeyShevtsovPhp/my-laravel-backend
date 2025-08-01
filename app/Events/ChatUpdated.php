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

    public int $userId;
    public Comment $comment;
    public string $username;

    public function __construct(User $user, Comment $comment)
    {
        $this->userId = $user->id;
        $this->comment = $comment;
        $this->username = $user->name;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat.' . $this->userId);
    }

    public function broadcastAs(): string
    {
        return 'chat.updated';
    }
}
