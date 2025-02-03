<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'lastname' => 'System',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // Contraseña cifrada
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Seller',
            'lastname' => 'One',
            'email' => 'seller@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
        ]);
    }
}
