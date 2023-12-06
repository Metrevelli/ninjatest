<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserToken;
use App\Repositories\Contracts\UsersRepositoryContract;

class UsersRepository implements UsersRepositoryContract
{
    public function __construct(private User $user)
    {
    }

    public function find(int $id): ?User
    {
        return $this->user->find($id);
    }

    public function create($data): User
    {
        return $this->user->create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->user->where('email', $email)->first();
    }

    public function findByToken(string $token): ?User
    {
        return UserToken::where('access_token', $token)->first()?->user;
    }
}
