<?php

namespace App\Http\Controllers;

use App\Models\Occurrence;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class OccurrenceVehicleController extends Controller
{
    /**
     * Vincula um veículo a uma ocorrência.
     */
    public function store(Request $request)
    {
        $request->validate([
            'occurrence_id' => 'required|exists:occurrences,id',
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);

        $occurrence = Occurrence::findOrFail($request->occurrence_id);

        // O método syncWithoutDetaching evita que o mesmo veículo seja adicionado duas vezes
        $occurrence->vehicles()->syncWithoutDetaching($request->vehicle_id);

        return back()->with('success', 'Veículo vinculado à ocorrência com sucesso.');
    }

    /**
     * Remove o vínculo de um veículo de uma ocorrência.
     */
    public function destroy(Occurrence $occurrence, Vehicle $vehicle)
    {
        // O método detach remove o vínculo da tabela-pivô
        $occurrence->vehicles()->detach($vehicle->id);

        return back()->with('success', 'Veículo desvinculado da ocorrência com sucesso.');
    }
}
