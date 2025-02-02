<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Listar usuarios
    public function index(): JsonResponse
    {
        return response()->json($this->userService->getAllUsers());
    }

    // Crear un usuario
    public function store(UserRequest $request): JsonResponse
    {
        return response()->json($this->userService->createUser($request->validated()), 201);
    }

    // Mostrar un usuario
    public function show(int $id): JsonResponse
    {
        return response()->json($this->userService->getUserById($id));
    }

    // Actualizar un usuario
    public function update(UserRequest $request, int $id): JsonResponse
    {
        return response()->json($this->userService->updateUser($id, $request->validated()));
    }

    // Eliminar un usuario
    public function destroy(int $id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
