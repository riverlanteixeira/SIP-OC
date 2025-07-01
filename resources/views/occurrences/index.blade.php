<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Boletins de Ocorrência') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('occurrences.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                        Registrar Nova Ocorrência
                    </a>
                    
                    <div class="overflow-x-auto mt-6">
                        <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Nº B.O.</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Data do Fato</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Local</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($occurrences as $occurrence)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium">{{ $occurrence->bo_number }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">{{ $occurrence->fact_date->format('d/m/Y H:i') }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">{{ $occurrence->location->name ?? 'Não especificado' }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-right space-x-2">
                                        {{-- CORREÇÃO: Link de 'Detalhes' descomentado --}}
                                        <a href="{{ route('occurrences.show', $occurrence) }}" class="inline-block rounded bg-teal-600 px-4 py-2 text-xs font-medium text-white hover:bg-teal-700">Detalhes</a>
                                        <a href="{{ route('occurrences.edit', $occurrence) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">Editar</a>
                                        <form action="{{ route('occurrences.destroy', $occurrence) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem a certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block rounded bg-red-600 px-4 py-2 text-xs font-medium text-white hover:bg-red-700">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">Nenhuma ocorrência registrada.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $occurrences->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
