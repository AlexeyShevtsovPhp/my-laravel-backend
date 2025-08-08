<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 */
class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const PER_PAGE = 100;

    public $timestamps = true;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
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
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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
}
