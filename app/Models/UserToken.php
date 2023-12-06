<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserToken extends Model
{
    use HasFactory;

    private const ACCESS_TOKEN_EXP_TIME_IN_DAYS = 30;

    public static function boot(): void
    {
        parent::boot();

        static::creating(static function (UserToken $token) {
            $token->access_token = Str::random(255);
            $token->expires_at = Carbon::now()->addDays(self::ACCESS_TOKEN_EXP_TIME_IN_DAYS);
        });
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expires_at','<=', now()->toDateTimeString());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getExpiresAtDate(): string
    {
        return $this->expires_at->toDateTimeString();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
