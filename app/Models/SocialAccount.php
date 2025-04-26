<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialAccount extends Model
{
    protected $fillable = [
        'provider_name',
        'provider_id',
        'token',
        'refresh_token',
        'expires_at',
    ];

    protected $casts = [
        'token' => 'encrypted',
        'refresh_token' => 'encrypted',
        'expires_at' => 'datetime',
    ];    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}