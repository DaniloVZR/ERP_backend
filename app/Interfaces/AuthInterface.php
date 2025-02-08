<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AuthInterface
{
    public function login(array $credentials): string;
    public function logout(Request $request): void;
}
