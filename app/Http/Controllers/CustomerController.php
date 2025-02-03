<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Throwable;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(): JsonResponse
    {
        try {
            return response()->json($this->customerService->getAllCustomers());
        } catch (Throwable $e) {
            return response()->json(['error' => 'Ocurrió un error interno al obtener la lista de clientes.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            return response()->json($this->customerService->getCustomerById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cliente no encontrado. Verifique el ID proporcionado.'], 404);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Ocurrió un error interno al obtener los detalles del cliente.'], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $customer = $this->customerService->createCustomer($request->all());
            return response()->json($customer, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Datos inválidos. Verifique la información enviada.'], 422);
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Ocurrió un error interno al crear el cliente.'], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $customer = $this->customerService->updateCustomer($id, $request->all());
            return response()->json($customer);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cliente no encontrado. Verifique el ID proporcionado.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Datos inválidos. Verifique la información enviada.'], 422);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Ocurrió un error interno al actualizar el cliente.'], 500);
        }
    }
    
    public function destroy($id): JsonResponse
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json(['error' => 'Acceso denegado. No tiene permisos suficientes para eliminar clientes.'], 403);
        }

        try {
            $this->customerService->deleteCustomer($id);
            return response()->json(['message' => 'Cliente eliminado correctamente.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cliente no encontrado. Verifique el ID proporcionado.'], 404);
        } catch (Throwable $e) {
            \Log::error('Error al eliminar el cliente: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Ocurrió un error interno al eliminar el cliente.'], 500);
        }
    }
}
