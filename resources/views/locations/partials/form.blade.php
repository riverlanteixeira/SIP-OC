<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Coluna da Esquerda: Campos de Texto -->
    <div class="space-y-4">
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome / Descrição do Local</label>
            <input id="name" name="name" type="text" value="{{ old('name', $location->name ?? '') }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipo</label>
            <select id="type" name="type" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                <option value="">Selecione um tipo...</option>
                @php
                    $currentType = old('type', $location->type ?? '');
                    $types = [
                        'Endereço residencial', 'Endereço comercial', 'Depósito de drogas', 'Depósito de armas',
                        'Ponto de tráfico', 'Boca de fumo itinerante', 'Local de corte/manipulação', 'Laboratório de produção',
                        'QG-base da organização', 'Local de lavagem de dinheiro', 'Central de delivery disque-drogas',
                        'Mocó (armazenagem temporária)', 'Ponto de reunião de usuários', 'Alojamento de criminosos'
                    ];
                @endphp
                @foreach ($types as $type)
                    <option value="{{ $type }}" @if($currentType == $type) selected @endif>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label for="registration_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Data de Cadastro</label>
            <input id="registration_date" name="registration_date" type="date" value="{{ old('registration_date', isset($location) ? ($location->registration_date ? $location->registration_date->format('Y-m-d') : date('Y-m-d')) : date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>

        <div>
            <label for="address" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Endereço</label>
            <input id="address" name="address" type="text" value="{{ old('address', $location->address ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="city" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Cidade</label>
            <input id="city" name="city" type="text" value="{{ old('city', $location->city ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="state" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Estado</label>
                <input id="state" name="state" type="text" value="{{ old('state', $location->state ?? 'SC') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            </div>
            <div>
                <label for="postal_code" class="block font-medium text-sm text-gray-700 dark:text-gray-300">CEP</label>
                <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $location->postal_code ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            </div>
        </div>
        <div>
            <button type="button" id="geocodeBtn" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold">Buscar Endereço no Mapa</button>
        </div>
         <div>
            <label for="notes" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Anotações</label>
            <textarea id="notes" name="notes" rows="2" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('notes', $location->notes ?? '') }}</textarea>
        </div>
    </div>

    <!-- Coluna da Direita: Mapa -->
    <div>
        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Marque a Posição Exata no Mapa</label>
        <div id="map" class="mt-1 h-96 w-full rounded-md border"></div>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label for="latitude" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Latitude</label>
                <input id="latitude" name="latitude" type="text" value="{{ old('latitude', $location->latitude ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm bg-gray-100 dark:bg-gray-700">
            </div>
            <div>
                <label for="longitude" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Longitude</label>
                <input id="longitude" name="longitude" type="text" value="{{ old('longitude', $location->longitude ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm bg-gray-100 dark:bg-gray-700">
            </div>
        </div>
    </div>
</div>

<div class="flex items-center justify-end mt-6">
    <a href="{{ route('locations.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400">Cancelar</a>
    <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">
        {{ isset($location) ? 'Atualizar Local' : 'Salvar Local' }}
    </button>
</div>
