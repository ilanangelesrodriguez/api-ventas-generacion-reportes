<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class CustomerService
{
    protected CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomers(): Collection
    {
        return $this->customerRepository->all();
    }

    public function getCustomerById($id)
    {
        return $this->customerRepository->find($id);
    }

    public function createCustomer(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'identification' => 'required|string|unique:customers',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->customerRepository->create($data);
    }

    public function updateCustomer($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'identification' => 'sometimes|required|string|unique:customers,identification,' . $id,
            'email' => 'sometimes|required|email|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->customerRepository->update($id, $data);
    }

    public function deleteCustomer($id)
    {
        return $this->customerRepository->delete($id);
    }
}
