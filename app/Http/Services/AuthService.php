<?php

namespace App\Http\Services;

use App\Interfaces\AuthServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function register(array $credentials)
    {
        $user = User::create($credentials);

        $token = $user->createToken($credentials['name']);

        return $token;
    }

    public function login(array $credentials): string
    {
        $user = User::where('email', $credentials['email'])->firstOrFail();

        if (!Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken(
            $user->name,
            ['*'],
            now()->addWeek()
        )->plainTextToken;

        return $token;
    }

    public function logout(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
