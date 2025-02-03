<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');

            $result = $this->authService->login($credentials);

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user());
            return response()->json(['message' => 'Sesión cerrada']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al cerrar sesión.'], 500);
        }
    }
}
