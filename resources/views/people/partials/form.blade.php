<!-- Nome Completo -->
<div>
    <label for="full_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome Completo</label>
    <input id="full_name" class="block mt-1 w-full rounded-md shadow-sm" type="text" name="full_name" value="{{ old('full_name', $person->full_name ?? '') }}" required autofocus />
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    <div>
        <label for="nickname" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Alcunha</label>
        <input id="nickname" class="block mt-1 w-full rounded-md shadow-sm" type="text" name="nickname" value="{{ old('nickname', $person->nickname ?? '') }}" />
    </div>
    <div>
        <label for="birth_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Data de Nascimento</label>
        <input id="birth_date" class="block mt-1 w-full rounded-md shadow-sm" type="date" name="birth_date" value="{{ old('birth_date', (isset($person) && $person->birth_date) ? $person->birth_date->format('Y-m-d') : '') }}" />
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    <div>
        <label for="cpf" class="block font-medium text-sm text-gray-700 dark:text-gray-300">CPF</label>
        <input id="cpf" class="block mt-1 w-full rounded-md shadow-sm" type="text" name="cpf" value="{{ old('cpf', $person->cpf ?? '') }}" />
    </div>
    <div>
        <label for="rg" class="block font-medium text-sm text-gray-700 dark:text-gray-300">RG</label>
        <input id="rg" class="block mt-1 w-full rounded-md shadow-sm" type="text" name="rg" value="{{ old('rg', $person->rg ?? '') }}" />
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    <div>
        <label for="mother_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome da Mãe</label>
        <input id="mother_name" class="block mt-1 w-full rounded-md shadow-sm" type="text" name="mother_name" value="{{ old('mother_name', $person->mother_name ?? '') }}" />
    </div>
    <div>
        <label for="father_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome do Pai</label>
        <input id="father_name" class="block mt-1 w-full rounded-md shadow-sm" type="text" name="father_name" value="{{ old('father_name', $person->father_name ?? '') }}" />
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    <div>
        <label for="gender" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Sexo</label>
        <select id="gender" name="gender" class="mt-1 block w-full rounded-md shadow-sm">
            <option value="">Selecione...</option>
            <option value="Masculino" @if(old('gender', $person->gender ?? '') == 'Masculino') selected @endif>Masculino</option>
            <option value="Feminino" @if(old('gender', $person->gender ?? '') == 'Feminino') selected @endif>Feminino</option>
        </select>
    </div>
    <div>
        <label for="skin_color" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Cor da Pele</label>
        <select id="skin_color" name="skin_color" class="mt-1 block w-full rounded-md shadow-sm">
            <option value="">Selecione...</option>
            <option value="Branco" @if(old('skin_color', $person->skin_color ?? '') == 'Branco') selected @endif>Branco</option>
            <option value="Negro" @if(old('skin_color', $person->skin_color ?? '') == 'Negro') selected @endif>Negro</option>
            <option value="Indígena" @if(old('skin_color', $person->skin_color ?? '') == 'Indígena') selected @endif>Indígena</option>
            <option value="Oriental" @if(old('skin_color', $person->skin_color ?? '') == 'Oriental') selected @endif>Oriental</option>
        </select>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    <div>
        <label for="birth_place" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Naturalidade</label>
        <input id="birth_place" class="block mt-1 w-full rounded-md shadow-sm" type="text" name="birth_place" value="{{ old('birth_place', $person->birth_place ?? '') }}" />
    </div>
    <div>
        <label for="nationality" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nacionalidade</label>
        <input id="nationality" class="block mt-1 w-full rounded-md shadow-sm" type="text" name="nationality" value="{{ old('nationality', $person->nationality ?? '') }}" />
    </div>
</div>

<!-- Anotações -->
<div class="mt-4">
    <label for="notes" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Anotações</label>
    <textarea id="notes" name="notes" rows="4" class="block mt-1 w-full rounded-md shadow-sm">{{ old('notes', $person->notes ?? '') }}</textarea>
</div>


<!-- Vínculo com Organizações e Funções -->
<div class="mt-6 border-t pt-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Organizações Vinculadas e Funções</h3>
    <div class="mt-4 space-y-4">
        @foreach ($organizations as $organization)
            <div class="flex items-center space-x-4 p-2 rounded-md @if(isset($person) && $person->organizations->contains($organization)) bg-gray-100 dark:bg-gray-700 @endif">
                <input type="checkbox" name="organizations[]" value="{{ $organization->id }}" @if(isset($person) && $person->organizations->contains($organization)) checked @endif class="h-5 w-5 rounded">
                <label class="flex-1 font-medium">{{ $organization->name }}</label>
                <select name="role_for_{{ $organization->id }}" class="w-1/2 rounded-md text-sm">
                    <option value="">Selecione a função...</option>
                    @php
                        $currentRole = '';
                        if (isset($person)) {
                            $pivot = $person->organizations->find($organization->id)?->pivot;
                            if ($pivot) { $currentRole = $pivot->role; }
                        }
                    @endphp
                    @foreach ($allRoles as $role)
                        <option value="{{ $role }}" @if($currentRole == $role) selected @endif>{{ $role }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
    </div>
</div>


<!-- Botões -->
<div class="flex items-center justify-end mt-4">
    <a href="{{ route('people.index') }}" class="underline text-sm">Cancelar</a>
    <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border-transparent rounded-md font-semibold text-xs text-white uppercase">
        {{ isset($person) ? 'Atualizar' : 'Salvar' }}
    </button>
</div>
