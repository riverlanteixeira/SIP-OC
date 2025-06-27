<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Veículos Cadastrados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('vehicles.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                        Cadastrar Novo Veículo
                    </a>
                    
                    <div class="overflow-x-auto mt-6">
                        <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Placa</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Marca/Modelo</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Ano</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Cor</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($vehicles as $vehicle)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium">{{ $vehicle->plate }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">{{ $vehicle->brand }} / {{ $vehicle->model }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">{{ $vehicle->year }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">{{ $vehicle->color }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-right space-x-2">
                                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                                            Editar
                                        </a>
                                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem a certeza?');">
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
                                    <td colspan="5" class="text-center py-4">Nenhum veículo cadastrado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $vehicles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
