<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombre' => 'Juan Diaz',
            'numero_documento' => '1003510437',
            'email' => '1003camilodiaz@gmail.com',
            'numero_telefono' => '3013623860',
            'direccion_residencia' => 'Calle 123, Ciudad, País',
            'numero_secundario' => '3125576730',
            'numero_terciario' => '3212196139',
            'tipo_usuario' => 'admin',
            'password' => Hash::make('1003510437'), 
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'nombre' => 'María Garcia',
            'numero_documento' => '87654322',
            'email' => 'maria.garcia@example.com',
            'numero_telefono' => '555-4321',
            'direccion_residencia' => 'Avenida Principal 456, Ciudad, País',
            'numero_secundario' => '555-8765',
            'numero_terciario' => '555-6789',
            'tipo_usuario' => 'cliente',
            'password' => null, 
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'nombre' => 'Carlos Rodríguez',
            'numero_documento' => '12349877',
            'email' => 'carlos.rodriguez@example.com',
            'numero_telefono' => '555-1122',
            'direccion_residencia' => 'Carrera 789, Ciudad, País',
            'numero_secundario' => '555-3344',
            'numero_terciario' => '555-5566',
            'tipo_usuario' => 'cliente',
            'password' => null, 
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'nombre' => 'Ana López',
            'numero_documento' => '87651235',
            'email' => 'ana.lopez@example.com',
            'numero_telefono' => '555-2211',
            'direccion_residencia' => 'Bulevar 101, Ciudad, País',
            'numero_secundario' => '555-4433',
            'numero_terciario' => '555-6655',
            'tipo_usuario' => 'cliente',
            'password' => null, 
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'nombre' => 'Luis Martínez',
            'numero_documento' => '12348766',
            'email' => 'luis.martinez@example.com',
            'numero_telefono' => '555-9988',
            'direccion_residencia' => 'Zona Industrial 202, Ciudad, País',
            'numero_secundario' => '555-7766',
            'numero_terciario' => '555-5544',
            'tipo_usuario' => 'cliente',
            'password' => null, 
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'nombre' => 'Sofía Hernández',
            'numero_documento' => '87654313',
            'email' => 'sofia.hernandez@example.com',
            'numero_telefono' => '555-8877',
            'direccion_residencia' => 'Edificio Central 303, Ciudad, País',
            'numero_secundario' => '555-6655',
            'numero_terciario' => '555-4433',
            'tipo_usuario' => 'cliente',
            'password' => null, 
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
