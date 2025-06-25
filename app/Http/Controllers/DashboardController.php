<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\Organization;
use App\Models\Person;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard principal da aplicação.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Contagem de investigações com o status "Em Andamento"
        $activeInvestigationsCount = Investigation::where('status', 'Em Andamento')->count();

        // Contagem total de pessoas
        $peopleCount = Person::count();

        // Contagem total de organizações
        $organizationsCount = Organization::count();

        // Pega as 5 investigações mais recentes
        $recentInvestigations = Investigation::latest()->take(5)->get();

        // Retorna a view 'dashboard' e passa todas as variáveis para ela
        return view('dashboard', [
            'activeInvestigationsCount' => $activeInvestigationsCount,
            'peopleCount' => $peopleCount,
            'organizationsCount' => $organizationsCount,
            'recentInvestigations' => $recentInvestigations,
        ]);
    }
}
