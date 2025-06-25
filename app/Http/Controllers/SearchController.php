<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\Organization;
use App\Models\Person;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Pega o termo de busca da URL (ex: /search?q=termo)
        $term = $request->input('q');

        // Inicializa arrays para os resultados
        $people = collect();
        $organizations = collect();
        $investigations = collect();

        // Só executa a busca se um termo for fornecido
        if ($term) {
            // CORREÇÃO: Troca 'LIKE' por 'ILIKE' para busca case-insensitive no PostgreSQL

            // Busca em Pessoas (por nome completo ou CPF)
            $people = Person::where('full_name', 'ILIKE', "%{$term}%")
                            ->orWhere('cpf', 'ILIKE', "%{$term}%")
                            ->get();

            // Busca em Organizações (por nome)
            $organizations = Organization::where('name', 'ILIKE', "%{$term}%")->get();

            // Busca em Investigações (por nome do caso ou descrição)
            $investigations = Investigation::where('case_name', 'ILIKE', "%{$term}%")
                                           ->orWhere('description', 'ILIKE', "%{$term}%")
                                           ->get();
        }

        // Retorna a view de resultados e passa todas as coleções de dados
        return view('search.results', compact('people', 'organizations', 'investigations', 'term'));
    }
}
