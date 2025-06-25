<!-- Nome Completo -->
<div>
    <label for="full_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome Completo</label>
    <input id="full_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" type="text" name="full_name" value="{{ old('full_name', $person->full_name ?? '') }}" required autofocus />
</div>

<!-- CPF -->
<div class="mt-4">
    <label for="cpf" class="block font-medium text-sm text-gray-700 dark:text-gray-300">CPF</label>
    <input id="cpf" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" type="text" name="cpf" value="{{ old('cpf', $person->cpf ?? '') }}" />
</div>

<!-- Data de Nascimento -->
<div class="mt-4">
    <label for="birth_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Data de Nascimento</label>
    <input id="birth_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" type="date" name="birth_date" value="{{ old('birth_date', isset($person) ? $person->birth_date->format('Y-m-d') : '') }}" />
</div>

<!-- Anotações -->
<div class="mt-4">
    <label for="notes" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Anotações</label>
    <textarea id="notes" name="notes" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('notes', $person->notes ?? '') }}</textarea>
</div>


<!-- Vínculo com Organizações -->
<div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Organizações Vinculadas</label>
    <div class="mt-2 space-y-2">
        @foreach ($organizations as $organization)
            <label class="flex items-center">
                {{-- AQUI ESTÁ A CORREÇÃO: type="checkbox" em vez de type-="checkbox" --}}
                <input type="checkbox" name="organizations[]" value="{{ $organization->id }}"
                    @if(isset($person) && $person->organizations->contains($organization->id)) checked @endif
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $organization->name }}</span>
            </label>
        @endforeach
    </div>
</div>


<!-- Botões -->
<div class="flex items-center justify-end mt-4">
    <a href="{{ route('people.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400">Cancelar</a>
    <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase">
        {{ isset($person) ? 'Atualizar' : 'Salvar' }}
    </button>
</div>