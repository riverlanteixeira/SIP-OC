<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Person;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::latest()->paginate(15);
        return view('bank_accounts.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('bank_accounts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bank_name' => 'required|string|max:255',
            'agency_number' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_type' => 'nullable|string|max:255',
        ]);

        BankAccount::create($validatedData);

        return redirect()->route('bank-accounts.index')->with('success', 'Conta bancária cadastrada com sucesso.');
    }

    public function edit(BankAccount $bankAccount)
    {
        $people = Person::orderBy('full_name')->get();
        $bankAccount->load('people');
        return view('bank_accounts.edit', compact('bankAccount', 'people'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $validatedData = $request->validate([
            'bank_name' => 'required|string|max:255',
            'agency_number' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_type' => 'nullable|string|max:255',
            'people' => 'nullable|array',
        ]);

        $bankAccount->update($validatedData);
        $bankAccount->people()->sync($request->input('people', []));

        return redirect()->route('bank-accounts.index')->with('success', 'Conta bancária atualizada com sucesso.');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return redirect()->route('bank-accounts.index')->with('success', 'Conta bancária excluída com sucesso.');
    }
}
