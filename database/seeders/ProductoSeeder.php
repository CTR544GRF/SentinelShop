<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            [
                'codigo' => '001',
                'nombre' => 'Café Juan Valdez',
                'precio' => 15000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '002',
                'nombre' => 'Chocolatina Jet',
                'precio' => 1000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '003',
                'nombre' => 'Galletas Festival',
                'precio' => 3000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '004',
                'nombre' => 'Arroz Diana',
                'precio' => 5000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '005',
                'nombre' => 'Aceite Premier',
                'precio' => 8000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '006',
                'nombre' => 'Arequipe Alpina',
                'precio' => 7000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '007',
                'nombre' => 'Pan Bimbo',
                'precio' => 4500.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '008',
                'nombre' => 'Queso Colanta',
                'precio' => 12000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '009',
                'nombre' => 'Leche Alquería',
                'precio' => 3500.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
