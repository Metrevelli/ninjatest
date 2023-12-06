<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AccessTokenResource;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{

    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->authService->register($data);

        return (new UserResource($user))->response();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $isValid = Auth::guard('token')->validate($data);

        if (! $isValid) {
            return response()->json([ 'message' => 'Invalid credentials' ]);
        }

        if (Gate::denies('login', Auth::user())) {
            return response()->json(['error' => 'Your account is not verified.'], 403);
        }

        $token = $this->authService->createToken();

        return (new AccessTokenResource($token))->response();
    }

    public function logout(): void
    {
        $token = auth()->getTokenFromRequest();
        $this->authService->revokeToken($token);
    }
}
