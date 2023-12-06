<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UsersRepositoryContract
{
    public function find(int $id): ?User;

    public function create($data): User;

    public function findByEmail(string $email): ?User;
}
