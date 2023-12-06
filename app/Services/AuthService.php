<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class AuthService
{
    public function __construct(private UsersService $usersService, private HasherContract $hasher)
    {
    }

    public function register($data): User
    {
        return $this->usersService->create($data);
    }

    public function retrieveById($identifier): ?Authenticatable
    {
        return $this->usersService->find($identifier);
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (empty($credentials['email'])) {
            return null;
        }

        return $this->usersService->findByEmail($credentials['email']);
    }

    public function retrieveByToken($token): ?Authenticatable
    {
        return $this->usersService->findByToken($token);
    }
    public function validateTokenCredentials(string $token): bool
    {
        return !! $this->usersService->findByToken($token);
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
//        dd($this->hasher->check($credentials['password'], $user->getAuthPassword()));
        return $this->hasher->check($credentials['password'], $user->getAuthPassword());
    }

    public function createToken(): UserToken
    {
        return auth()->user()->tokens()->create();
    }

    public function revokeToken($token): void
    {
        auth()->user()->tokens()->where('access_token', $token)->delete();
    }
}
