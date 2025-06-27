<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div>
        <label for="plate" class="block font-medium text-sm text-gray-700">Placa</label>
        <input id="plate" name="plate" type="text" value="{{ old('plate', $vehicle->plate ?? '') }}" required class="mt-1 block w-full rounded-md shadow-sm">
    </div>
    <div>
        <label for="brand" class="block font-medium text-sm text-gray-700">Marca</label>
        <input id="brand" name="brand" type="text" value="{{ old('brand', $vehicle->brand ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm">
    </div>
    <div>
        <label for="model" class="block font-medium text-sm text-gray-700">Modelo</label>
        <input id="model" name="model" type="text" value="{{ old('model', $vehicle->model ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm">
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
    <div>
        <label for="year" class="block font-medium text-sm text-gray-700">Ano</label>
        <input id="year" name="year" type="number" value="{{ old('year', $vehicle->year ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm">
    </div>
    <div>
        <label for="color" class="block font-medium text-sm text-gray-700">Cor</label>
        <input id="color" name="color" type="text" value="{{ old('color', $vehicle->color ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm">
    </div>
    <div>
        <label for="fuel_type" class="block font-medium text-sm text-gray-700">Combustível</label>
        <input id="fuel_type" name="fuel_type" type="text" value="{{ old('fuel_type', $vehicle->fuel_type ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm">
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
    <div>
        <label for="renavam" class="block font-medium text-sm text-gray-700">Renavam</label>
        <input id="renavam" name="renavam" type="text" value="{{ old('renavam', $vehicle->renavam ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm">
    </div>
    <div>
        <label for="chassis" class="block font-medium text-sm text-gray-700">Chassi</label>
        <input id="chassis" name="chassis" type="text" value="{{ old('chassis', $vehicle->chassis ?? '') }}" class="mt-1 block w-full rounded-md shadow-sm">
    </div>
</div>
<div class="mt-4">
    <label for="notes" class="block font-medium text-sm text-gray-700">Observações</label>
    <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md shadow-sm">{{ old('notes', $vehicle->notes ?? '') }}</textarea>
</div>
<div class="flex items-center justify-end mt-6">
    <a href="{{ route('vehicles.index') }}" class="underline text-sm">Cancelar</a>
    <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">
        {{ isset($vehicle) ? 'Atualizar Veículo' : 'Salvar Veículo' }}
    </button>
</div>
