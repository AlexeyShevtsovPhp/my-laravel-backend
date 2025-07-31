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


    public $comment;
    public $commentId;

    public function __construct($comment)
    {
        $this->commentId = $comment->id;
    }

    public function broadcastOn()
    {
        return new Channel('deleteComment' );
    }

    public function broadcastAs()
    {
        return 'chat.delete';
    }
}
