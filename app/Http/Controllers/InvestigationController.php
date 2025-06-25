<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\Person;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // 1. Importa a Trait necessária

class InvestigationController extends Controller
{
    use AuthorizesRequests; // 2. Usa a Trait, dando acesso ao método authorize()

    public function index()
    {
        // Se o utilizador for admin, mostra tudo.
        // Senão, mostra apenas as investigações às quais ele está atribuído.
        if (auth()->user()->hasRole('admin')) {
            $investigations = Investigation::latest()->paginate(10);
        } else {
            $investigations = auth()->user()->assignedInvestigations()->latest()->paginate(10);
        }
        
        return view('investigations.index', compact('investigations'));
    }

    public function create()
    {
        $people = Person::orderBy('full_name')->get();
        $organizations = Organization::orderBy('name')->get();
        // Apenas utilizadores com o papel 'investigator' podem ser atribuídos
        $investigators = User::whereHas('roles', fn($q) => $q->where('slug', 'investigator'))->get();

        return view('investigations.create', compact('people', 'organizations', 'investigators'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'case_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Em Andamento,Concluída,Suspensa',
            'people' => 'nullable|array',
            'organizations' => 'nullable|array',
            'users' => 'nullable|array'
        ]);

        $investigation = Investigation::create($validatedData);

        // Atribui o próprio utilizador que criou o caso como responsável
        $investigation->assignedUsers()->attach(auth()->user());

        // Atribui outros utilizadores selecionados no formulário
        if ($request->has('users')) {
            $investigation->assignedUsers()->syncWithoutDetaching($request->input('users'));
        }
        
        $investigation->people()->sync($request->input('people', []));
        $investigation->organizations()->sync($request->input('organizations', []));

        return redirect()->route('investigations.index')->with('success', 'Investigação iniciada com sucesso!');
    }

    public function show(Investigation $investigation)
    {
        // Usa a policy para verificar se o utilizador pode ver este caso
        $this->authorize('view', $investigation);

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
        $this->authorize('update', $investigation);

        $people = Person::orderBy('full_name')->get();
        $organizations = Organization::orderBy('name')->get();
        $investigators = User::whereHas('roles', fn($q) => $q->where('slug', 'investigator'))->get();

        return view('investigations.edit', compact('investigation', 'people', 'organizations', 'investigators'));
    }

    public function update(Request $request, Investigation $investigation)
    {
        $this->authorize('update', $investigation);

        $validatedData = $request->validate([
            'case_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Em Andamento,Concluída,Suspensa',
            'people' => 'nullable|array',
            'organizations' => 'nullable|array',
            'users' => 'nullable|array'
        ]);

        $investigation->update($validatedData);
        $investigation->people()->sync($request->input('people', []));
        $investigation->organizations()->sync($request->input('organizations', []));
        $investigation->assignedUsers()->sync($request->input('users', []));

        return redirect()->route('investigations.index')->with('success', 'Investigação atualizada com sucesso!');
    }
    
    public function destroy(Investigation $investigation)
    {
        $this->authorize('delete', $investigation);

        $investigation->delete();
        return redirect()->route('investigations.index')->with('success', 'Investigação excluída com sucesso!');
    }
}
