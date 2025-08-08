<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property int $price
 * @property int $name
 * @property Pivot $pivot
 * @property int $quantity
 */
class Good extends Model
{
    protected $fillable = ['name', 'price', 'category_id', 'image'];

    /**
     * @return BelongsTo<Category, $this>
     */

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsToMany<User, $this>
     */

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'carts', 'product_id', 'user_id')
            ->withPivot('quantity');
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function likedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes', 'good_id', 'user_id');
    }
}
