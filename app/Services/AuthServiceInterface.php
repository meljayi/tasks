<?php

namespace App\Services;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): User;
    public function login(array $credentials): string;
    public function logout(): void;
    public function getAuthenticatedUser();
}
