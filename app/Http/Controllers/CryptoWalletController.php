<?php

namespace App\Http\Controllers;

use App\Models\CryptoWallet;
use Illuminate\Http\Request;

class CryptoWalletController extends Controller
{
    public function index()
    {
        $wallets = CryptoWallet::latest()->paginate(15);
        return view('crypto_wallets.index', compact('wallets'));
    }

    public function create()
    {
        return view('crypto_wallets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'coin_type' => 'required|string|max:255',
            'address' => 'required|string|max:255|unique:crypto_wallets,address',
            'notes' => 'nullable|string',
        ]);

        CryptoWallet::create($request->all());

        return redirect()->route('crypto-wallets.index')->with('success', 'Carteira de criptomoedas cadastrada com sucesso.');
    }

    public function edit(CryptoWallet $cryptoWallet)
    {
        return view('crypto_wallets.edit', ['wallet' => $cryptoWallet]);
    }

    public function update(Request $request, CryptoWallet $cryptoWallet)
    {
        $request->validate([
            'coin_type' => 'required|string|max:255',
            'address' => 'required|string|max:255|unique:crypto_wallets,address,' . $cryptoWallet->id,
            'notes' => 'nullable|string',
        ]);

        $cryptoWallet->update($request->all());

        return redirect()->route('crypto-wallets.index')->with('success', 'Carteira de criptomoedas atualizada com sucesso.');
    }

    public function destroy(CryptoWallet $cryptoWallet)
    {
        $cryptoWallet->delete();
        return redirect()->route('crypto-wallets.index')->with('success', 'Carteira de criptomoedas excluída com sucesso.');
    }
}
