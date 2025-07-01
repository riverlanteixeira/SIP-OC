<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="coin_type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipo de Moeda (ex: Bitcoin, Ethereum)</label>
            <input type="text" id="coin_type" name="coin_type" value="{{ old('coin_type', $wallet->coin_type ?? '') }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="address" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Endereço da Carteira</label>
            <input type="text" id="address" name="address" value="{{ old('address', $wallet->address ?? '') }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 font-mono text-sm">
        </div>
    </div>
    <div>
        <label for="notes" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Anotações</label>
        <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('notes', $wallet->notes ?? '') }}</textarea>
    </div>
    <div class="flex items-center justify-end mt-4">
        <a href="{{ route('crypto-wallets.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400">Cancelar</a>
        <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            {{ isset($wallet) ? 'Atualizar' : 'Salvar' }}
        </button>
    </div>
</div>
