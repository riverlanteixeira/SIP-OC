<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div>
            <label for="bank_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome do Banco</label>
            <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $bankAccount->bank_name ?? '') }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="agency_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Agência</label>
            <input type="text" id="agency_number" name="agency_number" value="{{ old('agency_number', $bankAccount->agency_number ?? '') }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="account_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nº da Conta</label>
            <input type="text" id="account_number" name="account_number" value="{{ old('account_number', $bankAccount->account_number ?? '') }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
         <div>
            <label for="account_type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipo da Conta</label>
            {{-- ALTERAÇÃO: Input de texto substituído por um select --}}
            <select id="account_type" name="account_type" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                <option value="">Selecione...</option>
                <option value="Corrente" @if(old('account_type', $bankAccount->account_type ?? '') == 'Corrente') selected @endif>Corrente</option>
                <option value="Poupança" @if(old('account_type', $bankAccount->account_type ?? '') == 'Poupança') selected @endif>Poupança</option>
            </select>
        </div>
    </div>

    {{-- A secção de vinculação só aparece no modo de edição --}}
    @if (isset($bankAccount))
    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pessoas Vinculadas a esta Conta</h3>
        <div class="mt-4 space-y-2">
            @forelse ($people as $person)
                <label class="flex items-center">
                    <input type="checkbox" name="people[]" value="{{ $person->id }}" @if($bankAccount->people->contains($person)) checked @endif
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $person->full_name }}</span>
                </label>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma pessoa cadastrada para vincular.</p>
            @endforelse
        </div>
    </div>
    @endif

    <div class="flex items-center justify-end mt-6">
        <a href="{{ route('bank-accounts.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400">Cancelar</a>
        <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            {{ isset($bankAccount) ? 'Atualizar Conta' : 'Salvar Conta' }}
        </button>
    </div>
</div>
