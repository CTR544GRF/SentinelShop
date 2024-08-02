<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->truncateTables([
            'users',
            'fianzas',
            'productos',
        ]);

        $this->call(UserSeeder::class);
        $this->call(FianzaSeeder::class);
        $this->call(ProductoSeeder::class);
        
    }

    protected function truncateTables(array $tables){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }       
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}

