<?php

namespace App\Http\Controllers;

use App\Models\CryptoWallet;
use App\Models\Occurrence;
use Illuminate\Http\Request;

class OccurrenceCryptoWalletController extends Controller
{
    /**
     * Vincula uma carteira de criptomoedas a uma ocorrência.
     */
    public function store(Request $request)
    {
        $request->validate([
            'occurrence_id' => 'required|exists:occurrences,id',
            'crypto_wallet_id' => 'required|exists:crypto_wallets,id',
        ]);

        $occurrence = Occurrence::findOrFail($request->occurrence_id);
        $occurrence->cryptoWallets()->syncWithoutDetaching($request->crypto_wallet_id);

        return back()->with('success', 'Carteira Cripto vinculada com sucesso.');
    }

    /**
     * Remove o vínculo de uma carteira de criptomoedas de uma ocorrência.
     */
    public function destroy(Occurrence $occurrence, CryptoWallet $cryptoWallet)
    {
        $occurrence->cryptoWallets()->detach($cryptoWallet->id);
        return back()->with('success', 'Carteira Cripto desvinculada com sucesso.');
    }
}
