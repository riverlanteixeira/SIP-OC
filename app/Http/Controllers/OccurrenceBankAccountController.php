<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Occurrence;
use Illuminate\Http\Request;

class OccurrenceBankAccountController extends Controller
{
    /**
     * Vincula uma conta bancária a uma ocorrência.
     */
    public function store(Request $request)
    {
        $request->validate([
            'occurrence_id' => 'required|exists:occurrences,id',
            'bank_account_id' => 'required|exists:bank_accounts,id',
        ]);

        $occurrence = Occurrence::findOrFail($request->occurrence_id);
        $occurrence->bankAccounts()->syncWithoutDetaching($request->bank_account_id);

        return back()->with('success', 'Conta bancária vinculada com sucesso.');
    }

    /**
     * Remove o vínculo de uma conta bancária de uma ocorrência.
     */
    public function destroy(Occurrence $occurrence, BankAccount $bankAccount)
    {
        $occurrence->bankAccounts()->detach($bankAccount->id);
        return back()->with('success', 'Conta bancária desvinculada com sucesso.');
    }
}
