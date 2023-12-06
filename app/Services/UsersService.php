<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UsersRepositoryContract;

class UsersService
{
    public function __construct(private UsersRepositoryContract $repository)
    {
    }
    public function create($data): User
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        return $this->repository->create($userData);
    }

    public function find(int $id): ?User
    {
        return $this->repository->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findByEmail($email);
    }

    public function findByToken(string $token): ?User
    {
        return $this->repository->findByToken($token);
    }
}
