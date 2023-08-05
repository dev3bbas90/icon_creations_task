<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_no',
        'is_logout'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('logged', function(Builder $builder) {
            $builder->where('user_tokens.is_logout', 0);
        });
    }

    /**
     * Get the user that owns the UserTokens
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
