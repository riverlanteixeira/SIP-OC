<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalhes da Pessoa') }}
            </h2>
            <a href="{{ route('people.edit', $person->id) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                Editar Pessoa
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Detalhes da Pessoa -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ $person->full_name }}</h3>
                    <p><strong class="font-semibold">CPF:</strong> {{ $person->cpf ?? 'Não informado' }}</p>
                    <p class="mt-2"><strong class="font-semibold">Data de Nascimento:</strong> {{ $person->birth_date ? $person->birth_date->format('d/m/Y') : 'Não informada' }}</p>
                    <p class="mt-4"><strong class="font-semibold">Anotações:</strong></p>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $person->notes ?? 'Nenhuma anotação.' }}</p>
                </div>
            </div>

            <!-- Organizações Vinculadas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Organizações Vinculadas</h3>
                    <ul class="mt-4 list-disc list-inside">
                        @forelse($person->organizations as $organization)
                            <li class="text-gray-600 dark:text-gray-400">{{ $organization->name }}</li>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">Esta pessoa não está vinculada a nenhuma organização.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
