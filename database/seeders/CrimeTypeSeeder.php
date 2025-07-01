<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CrimeType; // Importa o modelo

class CrimeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $crimes = ['Homicídio', 'Roubo', 'Furto', 'Tráfico de Drogas', 'Latrocínio', 'Estelionato', 'Extorsão'];
        
        foreach ($crimes as $crime) {
            // Usa updateOrCreate para criar apenas se o nome não existir
            CrimeType::updateOrCreate(['name' => $crime]);
        }
    }
}