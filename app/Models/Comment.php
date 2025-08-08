<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $content
 * @property string $name
 * @property User $user
 * @property int $user_id
 * @property int $page
 */
class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    use HasFactory, Notifiable;

    public const PER_PAGE = 4;

    protected $table = 'comments';

    protected $fillable = ['user_id', 'content', 'category_id'];


    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}






