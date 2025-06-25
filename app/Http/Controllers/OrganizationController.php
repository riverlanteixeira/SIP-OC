<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ALTERAÇÃO: Trocamos latest()->get() por latest()->paginate()
        // Isto irá buscar apenas 10 registos por página.
        $organizations = Organization::latest()->paginate(10);

        return view('organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'area_of_operation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Organization::create($validatedData);

        return redirect()->route('organizations.index')->with('success', 'Organização cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        $organization->load('people');
        return view('organizations.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'area_of_operation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $organization->update($validatedData);

        return redirect()->route('organizations.index')->with('success', 'Organização atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Organização excluída com sucesso!');
    }
}
