<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FianzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha = Carbon::now()->format('Y-m-d');

        DB::table('fianzas')->insert([
            [
                'user_id' => 1,
                'fecha' => $fecha,
                'precio' => 1000.50,
                'estado' => true,
                'descripcion' => 'Descripción de prueba 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'fecha' => $fecha,
                'precio' => 2000.75,
                'estado' => false,
                'descripcion' => 'Descripción de prueba 2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'fecha' => $fecha,
                'precio' => 1500.00,
                'estado' => true,
                'descripcion' => 'Descripción de prueba 3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 4,
                'fecha' => $fecha,
                'precio' => 2500.50,
                'estado' => false,
                'descripcion' => 'Descripción de prueba 4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 5,
                'fecha' => $fecha,
                'precio' => 3000.00,
                'estado' => true,
                'descripcion' => 'Descripción de prueba 5',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}