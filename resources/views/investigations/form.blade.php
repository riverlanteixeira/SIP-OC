<!-- Nome do Caso -->
<div>
    <label for="case_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome do Caso</label>
    <input id="case_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" type="text" name="case_name" value="{{ old('case_name', $investigation->case_name ?? '') }}" required autofocus />
</div>

<!-- Status -->
<div class="mt-4">
    <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Status</label>
    <select id="status" name="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        @php
            $currentStatus = old('status', $investigation->status ?? 'Em Andamento');
        @endphp
        <option value="Em Andamento" @if($currentStatus == 'Em Andamento') selected @endif>Em Andamento</option>
        <option value="Concluída" @if($currentStatus == 'Concluída') selected @endif>Concluída</option>
        <option value="Suspensa" @if($currentStatus == 'Suspensa') selected @endif>Suspensa</option>
    </select>
</div>

<!-- Descrição -->
<div class="mt-4">
    <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Descrição</label>
    <textarea id="description" name="description" rows="6" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('description', $investigation->description ?? '') }}</textarea>
</div>

<!-- Pessoas Envolvidas -->
<div class="mt-4">
    <label for="people" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Pessoas Envolvidas</label>
    <select id="people" name="people[]" multiple class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        @foreach($people as $person)
            <option value="{{ $person->id }}"
                @if(isset($investigation) && $investigation->people->contains($person->id)) selected @endif
                {{-- Adiciona old() para manter a seleção em caso de erro de validação --}}
                @if(in_array($person->id, old('people', []))) selected @endif
            >
                {{ $person->full_name }}
            </option>
        @endforeach
    </select>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Selecione as pessoas relacionadas a esta investigação (segure Ctrl/Cmd para múltiplas seleções).</p>
</div>

<!-- Organizações Envolvidas -->
<div class="mt-4">
    <label for="organizations" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Organizações Envolvidas</label>
    <select id="organizations" name="organizations[]" multiple class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        @foreach($organizations as $organization)
            <option value="{{ $organization->id }}"
                @if(isset($investigation) && $investigation->organizations->contains($organization->id)) selected @endif
                {{-- Adiciona old() para manter a seleção em caso de erro de validação --}}
                @if(in_array($organization->id, old('organizations', []))) selected @endif
            >
                {{ $organization->name }}
            </option>
        @endforeach
    </select>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Selecione as organizações relacionadas a esta investigação (segure Ctrl/Cmd para múltiplas seleções).</p>
</div>

<!-- Investigadores Atribuídos -->
<div class="mt-4">
    <label for="users" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Investigadores Atribuídos</label>
    <select id="users" name="users[]" multiple class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        @foreach($investigators as $investigator)
            <option value="{{ $investigator->id }}" @if(isset($investigation) && $investigation->assignedUsers->contains($investigator->id)) selected @endif>{{ $investigator->name }}</option>
        @endforeach
    </select>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Selecione os investigadores responsáveis por esta investigação (segure Ctrl/Cmd para múltiplas seleções).</p>
</div>

<div class="flex items-center justify-end mt-4">
    <a href="{{ route('investigations.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400">Cancelar</a>
    <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase">
        {{ isset($investigation) ? 'Atualizar' : 'Salvar' }}
    </button>
</div>