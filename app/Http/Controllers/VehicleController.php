<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(15);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'plate' => 'required|string|max:10|unique:vehicles,plate',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|digits:4',
            'color' => 'nullable|string|max:50',
            'fuel_type' => 'nullable|string|max:50',
            'renavam' => 'nullable|string|max:11|unique:vehicles,renavam',
            'chassis' => 'nullable|string|max:17|unique:vehicles,chassis',
            'notes' => 'nullable|string',
        ]);

        Vehicle::create($validatedData);

        return redirect()->route('vehicles.index')->with('success', 'Veículo cadastrado com sucesso.');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validatedData = $request->validate([
            'plate' => 'required|string|max:10|unique:vehicles,plate,' . $vehicle->id,
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|digits:4',
            'color' => 'nullable|string|max:50',
            'fuel_type' => 'nullable|string|max:50',
            'renavam' => 'nullable|string|max:11|unique:vehicles,renavam,' . $vehicle->id,
            'chassis' => 'nullable|string|max:17|unique:vehicles,chassis,' . $vehicle->id,
            'notes' => 'nullable|string',
        ]);

        $vehicle->update($validatedData);

        return redirect()->route('vehicles.index')->with('success', 'Veículo atualizado com sucesso.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Veículo excluído com sucesso.');
    }
}
