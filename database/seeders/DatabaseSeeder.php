<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Chama os nossos seeders personalizados
        $this->call([
            RoleSeeder::class,
            CrimeTypeSeeder::class,
        ]);

        
    }
}
