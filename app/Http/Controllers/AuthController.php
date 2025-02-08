<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $requestValidated = $request->validate([
                'email' => 'required|exists:users,email|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $requestValidated['email'])->firstOrFail();

            if (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken(
                'token-name',
                ['*'],
                now()->addWeek()
            )->plainTextToken;

            return response()->json([
                'data' => $token
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al consultar el usuario',
                'data' => $th->getMessage(),
            ], 404);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
