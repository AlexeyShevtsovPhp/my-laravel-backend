<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ChatDelete implements ShouldBroadcast
{
    use SerializesModels;


    public Comment $comment;
    public int $commentId;

    public function __construct(Comment $comment)
    {
        $this->commentId = $comment->id;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('deleteComment' );
    }

    public function broadcastAs(): string
    {
        return 'chat.delete';
    }
}
