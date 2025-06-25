<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grelha de Cartões de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Cartão: Investigações Ativas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Investigações Ativas</h3>
                        <p class="mt-2 text-3xl font-semibold">{{ $activeInvestigationsCount }}</p>
                    </div>
                </div>

                <!-- Cartão: Pessoas Cadastradas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Pessoas Cadastradas</h3>
                        <p class="mt-2 text-3xl font-semibold">{{ $peopleCount }}</p>
                    </div>
                </div>

                <!-- Cartão: Organizações Monitorizadas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Organizações Monitorizadas</h3>
                        <p class="mt-2 text-3xl font-semibold">{{ $organizationsCount }}</p>
                    </div>
                </div>

            </div>

            <!-- Secção de Atividade Recente -->
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Atividade Recente</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Últimas investigações iniciadas.
                    </p>

                    <div class="mt-4">
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($recentInvestigations as $investigation)
                                <li class="py-3 flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $investigation->case_name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Iniciada em: {{ $investigation->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <a href="{{ route('investigations.show', $investigation) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                                        Ver Detalhes
                                    </a>
                                </li>
                            @empty
                                <li class="py-3 text-center text-gray-500 dark:text-gray-400">
                                    Nenhuma atividade recente.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
