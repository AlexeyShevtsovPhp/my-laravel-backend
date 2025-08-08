<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'good_id'];

    /**
     * @return BelongsTo<User, $this>
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Good, $this>
     */

    public function good(): BelongsTo
    {
        return $this->belongsTo(Good::class);
    }
}
