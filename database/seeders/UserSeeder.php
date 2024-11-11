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
            'nombre' => 'Pablo',
            'apellido_pat'=>'navarrete',
            'apellido_mat'=>'villalobos',
            'especialidad_id'=>1,
            'id_pais'=>1,
            'fecha_nacimiento'=>'2024-03-11',
            'genero'=>'masculino',
            'email' => 'pablo@tenant.cl',
            'rut'=>'19049484-5',
            'direccion'=>'calle llanquihue 256',
            'password' => bcrypt('12345678'), // Asegúrate de encriptar la contraseña
        ]);
    }
}
