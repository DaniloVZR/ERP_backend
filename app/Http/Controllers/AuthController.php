<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function login(LoginRequest $request)
    {
        try {
            $token = $this->authService->login($request->all());

            return response()->json([
                'success' => true,
                'data' => $token,
                'message' => '¡Sesión iniciada!',
                'errors' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Ha ocurrido un error al intentar iniciar sesión',
                'errors' => [
                    'message' => $th->getMessage(),
                    'code' => $th->getCode(),
                ]
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $token = $this->authService->register($request->all());

            return response()->json([
                'success' => true,
                'data' => $token,
                'message' => '¡Sesión iniciada!',
                'errors' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Ha ocurrido un error al intentar registrar',
                'errors' => [
                    'message' => $th->getMessage(),
                    'code' => $th->getCode(),
                ]
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request);

            return response()->noContent();
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Ha ocurrido un error al intentar cerrar sesión',
                'errors' => [
                    'message' => $th->getMessage(),
                    'code' => $th->getCode(),
                ]
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
