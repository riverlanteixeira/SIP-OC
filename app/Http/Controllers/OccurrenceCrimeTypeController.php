<?php

namespace App\Http\Controllers;

use App\Models\CrimeType;
use App\Models\Occurrence;
use Illuminate\Http\Request;

class OccurrenceCrimeTypeController extends Controller
{
    /**
     * Vincula um tipo de crime a uma ocorrência.
     */
    public function store(Request $request)
    {
        $request->validate([
            'occurrence_id' => 'required|exists:occurrences,id',
            'crime_type_id' => 'required|exists:crime_types,id',
        ]);

        $occurrence = Occurrence::findOrFail($request->occurrence_id);

        // O método syncWithoutDetaching evita que o mesmo tipo de crime seja adicionado duas vezes
        $occurrence->crimeTypes()->syncWithoutDetaching($request->crime_type_id);

        return back()->with('success', 'Fato comunicado adicionado com sucesso.');
    }

    /**
     * Remove o vínculo de um tipo de crime de uma ocorrência.
     */
    public function destroy(Occurrence $occurrence, CrimeType $crimeType)
    {
        // O método detach remove o vínculo da tabela-pivô
        $occurrence->crimeTypes()->detach($crimeType->id);

        return back()->with('success', 'Fato comunicado removido com sucesso.');
    }
}
