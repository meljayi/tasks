<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{

    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public function login(array $credentials): string
    {
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }

        $user = Auth::user();
        return $user->createToken('authToken')->plainTextToken;
    }

    public function logout(): void
    {
        request()->user()->currentAccessToken()->delete();
    }

    public function getAuthenticatedUser()
    {
        return request()->user();
    }
}
