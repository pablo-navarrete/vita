<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidad = [
            ['nombre' => 'psicología'],
            ['nombre' => 'urología'],
            ['nombre' => 'cardiología']
        ];
        

        DB::table('especialidads')->upsert($especialidad, ['nombre'], ['nombre']);
    }
}
