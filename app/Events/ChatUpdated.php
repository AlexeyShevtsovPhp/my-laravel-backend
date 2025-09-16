<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ChatUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public int $userId;
    public Comment $comment;
    public string $username;

    /**
     * @param User $user
     * @param Comment $comment
     */
    public function __construct(User $user, Comment $comment)
    {
        $this->userId = $user->id;
        $this->comment = $comment;
        $this->username = $user->name;
    }

    /**
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('chat.' . $this->userId);
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'chat.updated';
    }
}
