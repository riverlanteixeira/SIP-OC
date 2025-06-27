<?php

namespace App\Http\Controllers;

use App\Models\Incarceration;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IncarcerationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Guarda um novo período de reclusão.
     */
    public function store(Request $request)
    {
        $request->validate([
            'person_id' => 'required|exists:people,id',
            'prison_name' => 'required|string|max:255',
            'entry_date' => 'required|date',
            'exit_date' => 'nullable|date|after_or_equal:entry_date',
        ]);

        $person = Person::findOrFail($request->person_id);
        $this->authorize('update', $person); // Reutiliza a policy da Pessoa

        Incarceration::create($request->all());

        return back()->with('success', 'Período de reclusão adicionado com sucesso!');
    }

    /**
     * Apaga um período de reclusão.
     */
    public function destroy(Incarceration $incarceration)
    {
        $this->authorize('update', $incarceration->person); // Reutiliza a policy da Pessoa

        $incarceration->delete();

        return back()->with('success', 'Registo de reclusão removido com sucesso!');
    }
}
