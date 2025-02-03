<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Customer::create([
            'name' => 'John Doe',
            'identification' => 'DNI 12345678',
            'email' => 'john.doe@example.com',
            'phone' => '+123456789',
        ]);

        Customer::create([
            'name' => 'Jane Smith',
            'identification' => 'DNI 87654321',
            'email' => 'jane.smith@example.com',
            'phone' => '+987654321',
        ]);
    }
}
