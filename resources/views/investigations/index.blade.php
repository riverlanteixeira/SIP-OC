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

                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('investigations.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Iniciar Nova Investigação
                        </a>
                    </div>
                    
                    <!-- FORMULÁRIO DE FILTRO -->
                    <form action="{{ route('investigations.index') }}" method="GET" class="mt-4 border-t border-b dark:border-gray-700 py-4">
                        <div class="flex items-end space-x-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filtrar por Status</label>
                                <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Todos os Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" @if($currentStatus == $status) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Filtrar</button>
                            <a href="{{ route('investigations.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none">Limpar</a>
                        </div>
                    </form>


                    <div class="overflow-x-auto mt-6">
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
                                    <td class="whitespace-nowrap px-4 py-2 text-right space-x-2">
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
                                        Nenhum resultado encontrado para os filtros selecionados.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $investigations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
