<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Importa o modelo

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usa updateOrCreate para criar apenas se não existir, baseado no 'slug'
        Role::updateOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrador']
        );

        Role::updateOrCreate(
            ['slug' => 'investigator'],
            ['name' => 'Investigador']
        );
    }
}
