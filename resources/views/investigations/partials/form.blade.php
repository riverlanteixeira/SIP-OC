<!-- Campos existentes (Nome, Status, Descrição) -->
<div>
    <label for="case_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome do Caso</label>
    <input id="case_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" type="text" name="case_name" value="{{ old('case_name', $investigation->case_name ?? '') }}" required autofocus />
</div>

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

<div class="mt-4">
    <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Descrição</label>
    <textarea id="description" name="description" rows="6" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('description', $investigation->description ?? '') }}</textarea>
</div>

<!-- Vínculo com Pessoas (já existe) -->
<div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Pessoas Envolvidas
    </h3>
    <div class="mt-4 space-y-2">
        @forelse ($people as $person)
            <label class="flex items-center">
                <input type="checkbox" name="people[]" value="{{ $person->id }}"
                    @if(isset($investigation) && $investigation->people->contains($person->id)) checked @endif
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $person->full_name }}</span>
            </label>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma pessoa cadastrada para vincular.</p>
        @endforelse
    </div>
</div>

<!-- NOVA SEÇÃO: Vínculo com Organizações -->
<div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Organizações Envolvidas
    </h3>
    <div class="mt-4 space-y-2">
        @forelse ($organizations as $organization)
            <label class="flex items-center">
                <input type="checkbox" name="organizations[]" value="{{ $organization->id }}"
                    @if(isset($investigation) && $investigation->organizations->contains($organization->id)) checked @endif
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $organization->name }}</span>
            </label>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma organização cadastrada para vincular.</p>
        @endforelse
    </div>
</div>

<!-- NOVA SEÇÃO: Investigadores Responsáveis -->
{{-- Só mostra esta secção se o utilizador for administrador --}}
@can('is-admin')
<div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Investigadores Responsáveis
    </h3>
    <div class="mt-4 space-y-2">
        @forelse ($investigators as $investigator)
            <label class="flex items-center">
                <input type="checkbox" name="users[]" value="{{ $investigator->id }}"
                    @if(isset($investigation) && $investigation->assignedUsers->contains($investigator->id)) checked @endif
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $investigator->name }}</span>
            </label>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum utilizador com o papel "Investigador" encontrado.</p>
        @endforelse
    </div>
</div>
@endcan


<!-- Botões -->
<div class="flex items-center justify-end mt-4">
    <a href="{{ route('investigations.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400">Cancelar</a>
    <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase">
        {{ isset($investigation) ? 'Atualizar' : 'Salvar' }}
    </button>
</div>
