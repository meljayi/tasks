<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        $token = $user->createToken('authToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json(['access' => $response], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());
        return response()->json(['token' => $token], 200);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function user(): JsonResponse
    {
        $user = $this->authService->getAuthenticatedUser();

        return response()->json(['user' => $user], 200);
    }

}
