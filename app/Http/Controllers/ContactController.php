<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $request->validate([
            'person_id' => 'required|exists:people,id',
            'type' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $person = Person::findOrFail($request->person_id);
        $this->authorize('update', $person); // Reutiliza a policy da Pessoa para autorização

        Contact::create($request->all());

        return back()->with('success', 'Contacto adicionado com sucesso!');
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('update', $contact->person);

        $contact->delete();

        return back()->with('success', 'Contacto removido com sucesso!');
    }
}
