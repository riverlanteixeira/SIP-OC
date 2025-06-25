<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Organizações Criminosas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Botão para criar nova organização --}}
                    <a href="{{ route('organizations.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                        Cadastrar Nova Organização
                    </a>

                    {{-- Tabela de Organizações --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Nome</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Área de Atuação</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($organizations as $organization)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $organization->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 dark:text-gray-200">{{ $organization->area_of_operation }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <a href="{{ route('organizations.edit', $organization->id) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                                            Editar
                                        </a>
                                        {{-- Adicionaremos o botão de excluir depois --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>