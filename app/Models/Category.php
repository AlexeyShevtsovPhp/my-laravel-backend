<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    public $timestamps = false;

    /** @use HasFactory<CommentFactory> */
    use HasFactory, Notifiable;

    public const PER_PAGE = 10;

    /**
     * @return HasMany<Good, $this>
     */

    public function goods(): HasMany
    {
        return $this->hasMany(Good::class);
    }
}
