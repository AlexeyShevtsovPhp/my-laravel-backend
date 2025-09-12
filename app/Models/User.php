<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
/**
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $role
 * @property string $email
 * @property Collection<int, Good> $goods
 * @property \Illuminate\Support\Collection<int, int> $liked
 * @property float|int $totalSum
 * @property Collection<int, Good> $allGoods
 */
class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const PER_PAGE = 100;

    public $timestamps = true;

    protected $table = 'users';
    /**
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'password',
        'role',
        'email',
        'quantity',
    ];
    /**
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * @return HasMany<Comment, $this>
     */

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    /**
     * @return BelongsToMany<Good, $this>
     */
    public function goods(): BelongsToMany
    {
        return $this->belongsToMany(Good::class, 'carts', 'user_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }
    /**
     * @return BelongsToMany<Good, $this>
     */
    public function likedGoods(): BelongsToMany
    {
        return $this->belongsToMany(Good::class, 'likes', 'user_id', 'good_id');
    }

    public function getTotalGoodsSum(): float
    {
        return $this->goods->sum(function (Good $item) {
            /** @var Pivot&object{quantity: int} $pivot */
            $pivot = $item->pivot;
            return $item->price * $pivot->quantity;
        });
    }

    public function addToCart(int $productId): void
    {
        $existing = $this->goods()->where('product_id', $productId)->first();

        if ($existing) {
            /** @var Pivot&object{quantity: int} $pivot */
            $pivot = $existing->pivot;
            $currentQuantity = $pivot->quantity;

            $this->goods()->updateExistingPivot($productId, [
                'quantity' => $currentQuantity + 1,
            ]);
        } else {
            $this->goods()->attach($productId, ['quantity' => 1]);
        }
    }
}
