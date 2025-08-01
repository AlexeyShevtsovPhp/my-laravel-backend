<?php

namespace App\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $content
 * @property User $user
 * @property int $user_id
 */
class Comment extends Model
{

    /** @use HasFactory<CommentFactory> */
    use HasFactory, Notifiable;

    public const PER_PAGE = 4;

    protected $table = 'comments';
    protected $fillable = ['user_id', 'content', 'category_id'];

    public function user(): object
    {
        return $this->belongsTo(User::class);
    }
}

// select * from comments;
// [
//  {id:1, name: 'abc', user_id: 11},
//  {id:2, name: 'cdy', user_id: 22},
//  ]
//  $userIds = [11, 22, 33];
//
// select * from users where users.id in (11, 22, 33)
// [
//  {id:11, name: 'abc'},
//  {id:22, name: 'cdy'},
//  ]

$comments = Comment::query()->get();

$userIds = $comments->pluck('id')->toArray();
$users = User::query()
    ->whereIn('id', $userIds)
    ->get();

$comments = Comment::query()
    ->with('user')
    ->get();


// select * from comments;
$comments = Comment::query()
    ->get();


$comments = Comment::query()->get();

// select * from comments;

foreach ($comments as $comment) {
    // select * from user where id = $comment->user_id
    echo $comment->user->username;

}


$comments = Comment::query()->get();

$userIds = $comments->pluck('id')->toArray();
$users = User::query()
    ->whereIn('id', $userIds)
    ->get();

$comments = Comment::query()
    ->with('user')
    ->get();



