<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pablo',
            'email' => 'pablo@tenant.cl',
            'password' => bcrypt('12345678'), // Asegúrate de encriptar la contraseña
        ]);
    }
}
