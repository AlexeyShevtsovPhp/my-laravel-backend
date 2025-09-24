<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int|float $rating
 */
class Rate extends Model
{
    public $timestamps = false;
    protected $table = 'product_ratings';
    protected $fillable = ['product_id', 'user_id', 'rating'];
}
