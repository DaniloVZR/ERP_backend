<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function register(array $credentials);
    public function login(array $credentials): string;
    public function logout(Request $request): void;
}
