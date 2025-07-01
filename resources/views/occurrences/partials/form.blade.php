<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="bo_number" class="block font-medium text-sm text-gray-700">Nº do B.O. (Formato: UNIDADE-ANO-NÚMERO)</label>
            <input type="text" id="bo_number" name="bo_number" value="{{ old('bo_number', $occurrence->bo_number ?? '') }}" required class="mt-1 block w-full rounded-md shadow-sm">
        </div>
        <div>
            <label for="fact_date" class="block font-medium text-sm text-gray-700">Data e Hora do Fato</label>
            <input type="datetime-local" id="fact_date" name="fact_date" value="{{ old('fact_date', isset($occurrence) ? $occurrence->fact_date->format('Y-m-d\TH:i') : '') }}" required class="mt-1 block w-full rounded-md shadow-sm">
        </div>
    </div>
    <div>
        <label for="location_id" class="block font-medium text-sm text-gray-700">Local do Fato (Opcional)</label>
        <select id="location_id" name="location_id" class="mt-1 block w-full rounded-md shadow-sm">
            <option value="">Selecione um local cadastrado...</option>
            @foreach($locations as $location)
                <option value="{{ $location->id }}" @if(old('location_id', $occurrence->location_id ?? '') == $location->id) selected @endif>
                    {{ $location->name }} ({{ $location->city }})
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="report" class="block font-medium text-sm text-gray-700">Relato Geral da Ocorrência</label>
        <textarea id="report" name="report" rows="8" required class="mt-1 block w-full rounded-md shadow-sm">{{ old('report', $occurrence->report ?? '') }}</textarea>
    </div>
    <div class="flex items-center justify-end mt-4">
        <a href="{{ route('occurrences.index') }}" class="underline text-sm">Cancelar</a>
        <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">
            {{ isset($occurrence) ? 'Atualizar Ocorrência' : 'Salvar Ocorrência' }}
        </button>
    </div>
</div>
