<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ChatDelete implements ShouldBroadcast
{
    use SerializesModels;

    public Comment $comment;

    public int $commentId;
    /**
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->commentId = $comment->id;
    }
    /**
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('deleteComment');
    }
    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'chat.delete';
    }
}
