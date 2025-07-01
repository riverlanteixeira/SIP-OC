<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Carteiras de Criptomoedas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('crypto-wallets.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                        Cadastrar Nova Carteira
                    </a>

                    <div class="overflow-x-auto mt-6">
                        <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Tipo de Moeda</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Endereço da Carteira</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($wallets as $wallet)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2">{{ $wallet->coin_type }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 font-mono text-xs">{{ $wallet->address }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-right space-x-2">
                                        <a href="{{ route('crypto-wallets.edit', $wallet) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">Editar</a>
                                        <form action="{{ route('crypto-wallets.destroy', $wallet) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem a certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block rounded bg-red-600 px-4 py-2 text-xs font-medium text-white hover:bg-red-700">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4 text-gray-500">Nenhuma carteira cadastrada.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $wallets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
