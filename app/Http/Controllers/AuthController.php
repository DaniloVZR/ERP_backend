<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Interfaces\AuthInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthInterface $authService
    ) {}

    public function login(LoginRequest $request)
    {
        try {
            $token = $this->authService->login($request->all());

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
        $this->authService->logout($request);

        return response()->noContent();
    }
}
