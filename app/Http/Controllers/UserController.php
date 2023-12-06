<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\UserToken;
use App\Services\UsersService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private UsersService $usersService)
    {
    }

    public function show(): JsonResponse
    {
        $user = $this->usersService->find(auth()->user()->id);

        return (new UserResource($user))->response();
    }
}
