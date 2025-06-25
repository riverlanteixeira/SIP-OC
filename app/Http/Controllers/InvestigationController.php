<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\Person;
use App\Models\Organization;
use Illuminate\Http\Request;

class InvestigationController extends Controller
{
    public function index()
    {
        $investigations = Investigation::latest()->paginate(10);
        return view('investigations.index', compact('investigations'));
    }

    /**
     * Show the form for creating a new resource.
     * CORREÇÃO: Agora este método também busca Pessoas e Organizações.
     */
    public function create()
    {
        $people = Person::orderBy('full_name')->get();
        $organizations = Organization::orderBy('name')->get();

        return view('investigations.create', compact('people', 'organizations'));
    }

    /**
     * Store a newly created resource in storage.
     * CORREÇÃO: Agora este método também salva os vínculos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'case_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Em Andamento,Concluída,Suspensa',
            'people' => 'nullable|array',
            'organizations' => 'nullable|array'
        ]);

        // Primeiro, cria a investigação
        $investigation = Investigation::create($validatedData);

        // Depois, sincroniza os relacionamentos
        $investigation->people()->sync($request->input('people', []));
        $investigation->organizations()->sync($request->input('organizations', []));

        return redirect()->route('investigations.index')->with('success', 'Investigação iniciada com sucesso!');
    }

    public function show(Investigation $investigation)
    {
        $investigation->load('people.organizations', 'organizations.people');

        $nodes = [];
        $edges = [];

        $nodes[] = ['id' => 'inv_'.$investigation->id, 'label' => $investigation->case_name, 'group' => 'investigation', 'shape' => 'box', 'color' => '#f0ad4e'];

        foreach ($investigation->people as $person) {
            $nodes[] = ['id' => 'p_'.$person->id, 'label' => $person->full_name, 'group' => 'person', 'shape' => 'ellipse', 'color' => '#5bc0de'];
            $edges[] = ['from' => 'inv_'.$investigation->id, 'to' => 'p_'.$person->id];

            foreach ($person->organizations as $org) {
                if ($investigation->organizations->contains($org)) {
                    $edges[] = ['from' => 'p_'.$person->id, 'to' => 'org_'.$org->id, 'dashes' => true];
                }
            }
        }

        foreach ($investigation->organizations as $organization) {
            if (!collect($nodes)->contains('id', 'org_'.$organization->id)) {
                $nodes[] = ['id' => 'org_'.$organization->id, 'label' => $organization->name, 'group' => 'organization', 'shape' => 'dot', 'color' => '#d9534f', 'size' => 20];
            }
            $edges[] = ['from' => 'inv_'.$investigation->id, 'to' => 'org_'.$organization->id];
        }

        $edges = array_unique($edges, SORT_REGULAR);

        return view('investigations.show', [
            'investigation' => $investigation,
            'graphData' => [
                'nodes' => array_values($nodes),
                'edges' => array_values($edges),
            ]
        ]);
    }

    public function edit(Investigation $investigation)
    {
        $people = Person::orderBy('full_name')->get();
        $organizations = Organization::orderBy('name')->get();
        return view('investigations.edit', compact('investigation', 'people', 'organizations'));
    }

    public function update(Request $request, Investigation $investigation)
    {
        $validatedData = $request->validate([
            'case_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Em Andamento,Concluída,Suspensa',
            'people' => 'nullable|array',
            'organizations' => 'nullable|array'
        ]);
        $investigation->update($validatedData);
        $investigation->people()->sync($request->input('people', []));
        $investigation->organizations()->sync($request->input('organizations', []));
        return redirect()->route('investigations.index')->with('success', 'Investigação atualizada com sucesso!');
    }
    
    public function destroy(Investigation $investigation)
    {
        $investigation->delete();
        return redirect()->route('investigations.index')->with('success', 'Investigação excluída com sucesso!');
    }
}
