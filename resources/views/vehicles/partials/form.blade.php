<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="plate" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Placa</label>
            {{-- CORREÇÃO: Removido o atributo 'required' para confiar na validação do backend --}}
            <input id="plate" name="plate" type="text" value="{{ old('plate', $vehicle->plate ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="brand" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Marca</label>
            <input id="brand" name="brand" type="text" value="{{ old('brand', $vehicle->brand ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="model" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Modelo</label>
            <input id="model" name="model" type="text" value="{{ old('model', $vehicle->model ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
        <div>
            <label for="year" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ano</label>
            <input id="year" name="year" type="number" value="{{ old('year', $vehicle->year ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="color" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Cor</label>
            <input id="color" name="color" type="text" value="{{ old('color', $vehicle->color ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="fuel_type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Combustível</label>
            <input id="fuel_type" name="fuel_type" type="text" value="{{ old('fuel_type', $vehicle->fuel_type ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <div>
            <label for="renavam" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Renavam</label>
            <input id="renavam" name="renavam" type="text" value="{{ old('renavam', $vehicle->renavam ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
        <div>
            <label for="chassis" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Chassi</label>
            <input id="chassis" name="chassis" type="text" value="{{ old('chassis', $vehicle->chassis ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        </div>
    </div>
    <div class="mt-4">
        <label for="notes" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Observações</label>
        <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('notes', $vehicle->notes ?? '') }}</textarea>
    </div>
    <div class="flex items-center justify-end mt-6">
        <a href="{{ route('vehicles.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            Cancelar
        </a>
        <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            {{ isset($vehicle) ? 'Atualizar Veículo' : 'Salvar Veículo' }}
        </button>
    </div>
</div>
