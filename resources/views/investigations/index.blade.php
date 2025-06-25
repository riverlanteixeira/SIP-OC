<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Investigações') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700 dark:bg-green-900 dark:text-green-200" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('investigations.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                        Iniciar Nova Investigação
                    </a>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Nome do Caso</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Status</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($investigations as $investigation)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $investigation->case_name }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 dark:text-gray-200">{{ $investigation->status }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-right">
                                        <a href="{{ route('investigations.show', $investigation) }}" class="inline-block rounded bg-teal-600 px-4 py-2 text-xs font-medium text-white hover:bg-teal-700">
                                            Ver Detalhes
                                        </a>
                                        <a href="{{ route('investigations.edit', $investigation->id) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                                            Gerenciar
                                        </a>
                                        <form action="{{ route('investigations.destroy', $investigation->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block rounded bg-red-600 px-4 py-2 text-xs font-medium text-white hover:bg-red-700">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                        Nenhuma investigação em andamento.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- ADICIONADO: Links da Paginação -->
                    <div class="mt-4">
                        {{ $investigations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
