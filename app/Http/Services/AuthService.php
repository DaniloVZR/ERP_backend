<?php

namespace App\Http\Services;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthInterface
{
    public function login($credentials): string
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

    public function logout($request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
