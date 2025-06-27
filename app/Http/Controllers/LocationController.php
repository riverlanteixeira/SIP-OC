<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::latest()->paginate(15);
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateLocation($request);
        Location::create($validatedData);
        return redirect()->route('locations.index')->with('success', 'Local cadastrado com sucesso.');
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $validatedData = $this->validateLocation($request);
        $location->update($validatedData);
        return redirect()->route('locations.index')->with('success', 'Local atualizado com sucesso.');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Local excluído com sucesso.');
    }

    private function validateLocation(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'registration_date' => 'nullable|date', // Validação para o novo campo
        ]);
    }
}
