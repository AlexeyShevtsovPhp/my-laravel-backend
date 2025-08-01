<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $price
 * @property int $name
 */
class Good extends Model
{
    protected $fillable = ['name', 'price','category_id','image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'carts', 'product_id', 'user_id')
            ->withPivot('quantity');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'good_id', 'user_id');
    }

}
