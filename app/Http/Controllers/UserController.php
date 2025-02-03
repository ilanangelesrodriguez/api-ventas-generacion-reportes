<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Listar usuarios
    public function index(): JsonResponse
    {
        try {
            return response()->json($this->userService->getAllUsers());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al listar usuarios', 'message' => $e->getMessage()], 500);
        }
    }

    // Crear un usuario
    public function store(UserRequest $request): JsonResponse
    {
        try {
            return response()->json($this->userService->createUser($request->validated()), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear usuario', 'message' => $e->getMessage()], 500);
        }
    }

    // Mostrar un usuario
    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->userService->getUserById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuario no encontrado', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al mostrar usuario', 'message' => $e->getMessage()], 500);
        }
    }

    // Actualizar un usuario
    public function update(UserRequest $request, int $id): JsonResponse
    {
        try {
            return response()->json($this->userService->updateUser($id, $request->validated()));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuario no encontrado', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar usuario', 'message' => $e->getMessage()], 500);
        }
    }

    // Eliminar un usuario
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);
            return response()->json(['message' => 'Usuario eliminado correctamente']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuario no encontrado', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar usuario', 'message' => $e->getMessage()], 500);
        }
    }
}
