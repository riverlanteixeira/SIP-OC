<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        // Busca as pessoas de forma paginada
        $people = \App\Models\Person::latest()->paginate(10);

        // Retorna a view 'people.index' e passa a variável 'people' para ela
        return view('people.index', ['people' => $people]);
    }

    public function create()
    {
        $organizations = Organization::orderBy('name')->get();
        return view('people.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'cpf' => 'nullable|string|max:14|unique:people,cpf',
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'organizations' => 'nullable|array'
        ]);

        $person = Person::create($validatedData);
        $person->organizations()->sync($request->input('organizations', []));

        return redirect()->route('people.index')->with('success', 'Pessoa cadastrada com sucesso!');
    }

    public function show(Person $person)
    {
        $person->load('organizations');
        return view('people.show', compact('person'));
    }

    public function edit(Person $person)
    {
        $organizations = Organization::orderBy('name')->get();
        return view('people.edit', compact('person', 'organizations'));
    }

    public function update(Request $request, Person $person)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'cpf' => 'nullable|string|max:14|unique:people,cpf,'.$person->id,
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'organizations' => 'nullable|array'
        ]);

        $person->update($validatedData);
        $person->organizations()->sync($request->input('organizations', []));

        return redirect()->route('people.index')->with('success', 'Dados da pessoa atualizados com sucesso!');
    }

    public function destroy(Person $person)
    {
        $person->delete();
        return redirect()->route('people.index')->with('success', 'Pessoa excluída com sucesso!');
    }
}
