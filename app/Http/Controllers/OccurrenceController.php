<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Occurrence;
use App\Models\Person;
use App\Models\CrimeType;
use App\Models\Vehicle;
use App\Models\BankAccount;
use App\Models\CryptoWallet;
use Illuminate\Http\Request;

class OccurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $occurrences = Occurrence::with('location')->latest()->paginate(15);
        return view('occurrences.index', compact('occurrences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('name')->get();
        return view('occurrences.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bo_number' => 'required|string|max:255|unique:occurrences,bo_number',
            'fact_date' => 'required|date',
            'location_id' => 'nullable|exists:locations,id',
            'report' => 'required|string',
        ]);

        $occurrence = Occurrence::create($validatedData);

        return redirect()->route('occurrences.show', $occurrence)->with('success', 'Ocorrência cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Occurrence $occurrence)
    {
        // Carrega todos os relacionamentos necessários de uma só vez
        $occurrence->load('location', 'people', 'crimeTypes', 'documents', 'vehicles', 'bankAccounts', 'cryptoWallets');
        
        // Busca os dados necessários para os formulários da página
        $people = Person::orderBy('full_name')->get();
        $crimeTypes = CrimeType::orderBy('name')->get();
        $vehicles = Vehicle::orderBy('plate')->get();
        $bankAccounts = BankAccount::all();
        $cryptoWallets = CryptoWallet::all();

        // Retorna a view com todas as variáveis necessárias
        return view('occurrences.show', compact('occurrence', 'people', 'crimeTypes', 'vehicles', 'bankAccounts', 'cryptoWallets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Occurrence $occurrence)
    {
        $locations = Location::orderBy('name')->get();
        return view('occurrences.edit', compact('occurrence', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Occurrence $occurrence)
    {
        $validatedData = $request->validate([
            'bo_number' => 'required|string|max:255|unique:occurrences,bo_number,' . $occurrence->id,
            'fact_date' => 'required|date',
            'location_id' => 'nullable|exists:locations,id',
            'report' => 'required|string',
        ]);

        $occurrence->update($validatedData);

        return redirect()->route('occurrences.show', $occurrence)->with('success', 'Ocorrência atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Occurrence $occurrence)
    {
        $occurrence->delete();
        return redirect()->route('occurrences.index')->with('success', 'Ocorrência excluída com sucesso.');
    }
}
