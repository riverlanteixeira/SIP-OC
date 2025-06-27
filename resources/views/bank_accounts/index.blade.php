<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contas Bancárias') }}
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

                    <a href="{{ route('bank-accounts.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                        Cadastrar Nova Conta
                    </a>

                    <div class="overflow-x-auto mt-6">
                        <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Banco</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Agência</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Conta</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($bankAccounts as $account)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $account->bank_name }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 dark:text-gray-200">{{ $account->agency_number }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 dark:text-gray-200">{{ $account->account_number }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-right space-x-2">
                                        <a href="{{ route('bank-accounts.edit', $account) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                                            Editar / Vincular
                                        </a>
                                        <form action="{{ route('bank-accounts.destroy', $account) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem a certeza?');">
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
                                    <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                        Nenhuma conta bancária cadastrada.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $bankAccounts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
