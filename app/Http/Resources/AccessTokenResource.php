<?php

namespace App\Http\Resources;

use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessTokenResource extends JsonResource
{
    public function __construct(UserToken $resource)
    {
        $this->resource = $resource;
    }

    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->resource->getAccessToken(),
            'expires_at'   => $this->resource->getExpiresAtDate(),
        ];
    }
}
