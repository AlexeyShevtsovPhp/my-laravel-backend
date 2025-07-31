<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $role
 */
class User extends Authenticatable
{
    public const ROLE_ADMIN = 'admin';
    protected $table = 'users';
    use HasApiTokens;

    public const PER_PAGE = 100;
    public $timestamps = true;

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'password' => 'hashed',
        ];
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function goods()
    {
        return $this->belongsToMany(Good::class, 'carts', 'user_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function likedGoods()
    {
        return $this->belongsToMany(Good::class, 'likes', 'user_id', 'good_id');
    }

}
