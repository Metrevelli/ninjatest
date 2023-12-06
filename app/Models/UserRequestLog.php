<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class UserRequestLog extends Model
{
    use HasFactory;

    protected $casts = [
        'request_params' => 'array',
    ];

    protected $fillable = ['user_id', 'token_id', 'request_method', 'request_params'];

    public static function boot(): void
    {
        parent::boot();

        static::created(static function (UserRequestLog $requestLog) {
            $requestLog->user()->increment('requests_count');
        });
    }

    public static function getRequestMethods(): array
    {
        return [
            Request::METHOD_GET,
            Request::METHOD_POST,
            Request::METHOD_PUT,
            Request::METHOD_PATCH,
            Request::METHOD_DELETE,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
