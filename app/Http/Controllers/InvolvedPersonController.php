<?php

namespace App\Http\Controllers;

use App\Models\Occurrence;
use App\Models\Person;
use Illuminate\Http\Request;

class InvolvedPersonController extends Controller
{
    /**
     * Vincula uma pessoa a uma ocorrência.
     */
    public function store(Request $request)
    {
        $request->validate([
            'occurrence_id' => 'required|exists:occurrences,id',
            'person_id' => 'required|exists:people,id',
            'participation_type' => 'required|string|max:255',
            'individual_report' => 'nullable|string',
        ]);

        $occurrence = Occurrence::findOrFail($request->occurrence_id);

        // O método syncWithoutDetaching evita que a mesma pessoa seja adicionada duas vezes
        $occurrence->people()->syncWithoutDetaching([
            $request->person_id => [
                'participation_type' => $request->participation_type,
                'individual_report' => $request->individual_report,
            ]
        ]);

        return back()->with('success', 'Pessoa adicionada à ocorrência com sucesso.');
    }

    /**
     * Remove o vínculo de uma pessoa de uma ocorrência.
     */
    public function destroy(Occurrence $occurrence, Person $person)
    {
        // O método detach remove o vínculo da tabela-pivô
        $occurrence->people()->detach($person->id);

        return back()->with('success', 'Pessoa removida da ocorrência com sucesso.');
    }
}
