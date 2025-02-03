<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $credentials): array
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];
        }

        throw new \Exception('Credenciales inválidas');
    }

    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }
}
