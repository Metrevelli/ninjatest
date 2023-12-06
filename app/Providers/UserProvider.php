<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\AuthService;
use Illuminate\Contracts\Auth\Authenticatable;
use \Illuminate\Contracts\Auth\UserProvider as BaseUserProvider;
use JetBrains\PhpStorm\NoReturn;

class UserProvider implements BaseUserProvider
{
    public function __construct(private AuthService $authService)
    {
    }

    public function retrieveById($identifier): ?Authenticatable
    {
        return $this->authService->retrieveById($identifier);
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        return $this->authService->retrieveByCredentials($credentials);
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return $this->authService->validateCredentials($user, $credentials);
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        return $this->authService->retrieveByToken($token);
    }

    public function validateTokenCredentials($token): bool
    {
        return !! $this->authService->validateTokenCredentials($token);
    }

    #[NoReturn]
    public function updateRememberToken(Authenticatable $user, $token): void
    {
        die();
    }
}
