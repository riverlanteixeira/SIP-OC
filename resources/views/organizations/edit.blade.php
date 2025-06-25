<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Organização: ') }} {{ $organization->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('organizations.update', $organization->id) }}">
                        @csrf
                        @method('PUT') {{-- Informa ao Laravel que é uma ATUALIZAÇÃO --}}

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome</label>
                            <input id="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" type="text" name="name" value="{{ old('name', $organization->name) }}" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="area_of_operation" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Área de Atuação</label>
                            <input id="area_of_operation" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" type="text" name="area_of_operation" value="{{ old('area_of_operation', $organization->area_of_operation) }}" />
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Descrição</label>
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('description', $organization->description) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('organizations.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancelar</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase">Atualizar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>