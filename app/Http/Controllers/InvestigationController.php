<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\Person;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Barryvdh\DomPDF\Facade\Pdf;

class InvestigationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        // Inicia a construção da query
        $query = Investigation::query();

        // Se o utilizador não for admin, filtra para mostrar apenas os seus casos
        if (!auth()->user()->hasRole('admin')) {
            $query->whereHas('assignedUsers', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        // Se um filtro de status foi enviado, aplica-o à query
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ordena pelos mais recentes e pagina os resultados
        // withQueryString() garante que os filtros sejam mantidos na paginação
        $investigations = $query->latest()->paginate(10)->withQueryString();

        return view('investigations.index', [
            'investigations' => $investigations,
            'statuses' => ['Em Andamento', 'Concluída', 'Suspensa'], // Lista de status para o dropdown
            'currentStatus' => $request->status ?? '' // Status atualmente selecionado
        ]);
    }

    public function create()
    {
        $this->authorize('create', Investigation::class);
        $people = Person::orderBy('full_name')->get();
        $organizations = Organization::orderBy('name')->get();
        $investigators = User::whereHas('roles', fn($q) => $q->where('slug', 'investigator'))->get();
        return view('investigations.create', compact('people', 'organizations', 'investigators'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Investigation::class);
        $validatedData = $request->validate([
            'case_name' => 'required|string|max:255', 'description' => 'nullable|string', 'status' => 'required|string|in:Em Andamento,Concluída,Suspensa',
            'people' => 'nullable|array', 'organizations' => 'nullable|array', 'users' => 'nullable|array'
        ]);
        $investigation = Investigation::create($validatedData);
        $assignedUsers = $request->input('users', []);
        $assignedUsers[] = auth()->id();
        $investigation->assignedUsers()->sync(array_unique($assignedUsers));
        $investigation->people()->sync($request->input('people', []));
        $investigation->organizations()->sync($request->input('organizations', []));
        return redirect()->route('investigations.index')->with('success', 'Investigação iniciada com sucesso!');
    }

    public function show(Investigation $investigation)
    {
        $this->authorize('view', $investigation);
        $investigation->load('people.organizations', 'organizations.people', 'documents', 'assignedUsers');
        $nodes = []; $edges = []; $addedNodeIds = [];
        $nodeId = 'inv_'.$investigation->id;
        $nodes[] = ['id' => $nodeId, 'label' => $investigation->case_name, 'group' => 'investigation', 'shape' => 'box', 'color' => '#f0ad4e'];
        $addedNodeIds[$nodeId] = true;
        foreach ($investigation->people as $person) {
            $nodeId = 'p_'.$person->id;
            if (!isset($addedNodeIds[$nodeId])) {
                $nodes[] = ['id' => $nodeId, 'label' => $person->full_name, 'group' => 'person', 'shape' => 'ellipse', 'color' => '#5bc0de'];
                $addedNodeIds[$nodeId] = true;
            }
            $edges[] = ['from' => 'inv_'.$investigation->id, 'to' => $nodeId];
            foreach ($person->organizations as $org) {
                if ($investigation->organizations->contains($org)) {
                    $edges[] = ['from' => $nodeId, 'to' => 'org_'.$org->id, 'dashes' => true];
                }
            }
        }
        foreach ($investigation->organizations as $organization) {
            $nodeId = 'org_'.$organization->id;
            if (!isset($addedNodeIds[$nodeId])) {
                $nodes[] = ['id' => $nodeId, 'label' => $organization->name, 'group' => 'organization', 'shape' => 'dot', 'color' => '#d9534f', 'size' => 20];
                $addedNodeIds[$nodeId] = true;
            }
            $edges[] = ['from' => 'inv_'.$investigation->id, 'to' => $nodeId];
        }
        $edges = array_unique($edges, SORT_REGULAR);
        return view('investigations.show', [
            'investigation' => $investigation,
            'graphData' => ['nodes' => $nodes, 'edges' => $edges]
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
            'case_name' => 'required|string|max:255', 'description' => 'nullable|string', 'status' => 'required|string|in:Em Andamento,Concluída,Suspensa',
            'people' => 'nullable|array', 'organizations' => 'nullable|array', 'users' => 'nullable|array'
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

    public function downloadPdf(Investigation $investigation)
    {
        $this->authorize('view', $investigation);
        $investigation->load('people', 'organizations', 'documents', 'assignedUsers');
        $pdf = Pdf::loadView('investigations.pdf', compact('investigation'));
        return $pdf->download('relatorio-investigacao-'.$investigation->id.'.pdf');
    }
}
