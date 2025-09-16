<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
    use HasFactory;
    use Notifiable;

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

    /**
     * @param Request $request
     * @return Builder<$this>
     */

    public static function buildCommentQuery(Request $request): Builder
    {
        $query = Comment::query()->with('user');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        return $query;
    }
}
