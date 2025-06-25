<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Resultados da Busca') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <p class="text-lg text-gray-900 dark:text-gray-100">
                    @if ($term)
                        Exibindo resultados para: <span class="font-semibold">{{ $term }}</span>
                    @else
                        Por favor, digite um termo na barra de busca.
                    @endif
                </p>
            </div>

            <!-- Resultados de Pessoas -->
            @if($people->count() > 0)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pessoas Encontradas ({{ $people->count() }})</h3>
                <ul class="mt-4 list-disc list-inside">
                    @foreach($people as $person)
                    <li>
                        <a href="{{ route('people.show', $person) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ $person->full_name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Resultados de Organizações -->
            @if($organizations->count() > 0)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Organizações Encontradas ({{ $organizations->count() }})</h3>
                <ul class="mt-4 list-disc list-inside">
                    @foreach($organizations as $organization)
                    <li>
                        <a href="{{ route('organizations.show', $organization) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ $organization->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Resultados de Investigações -->
            @if($investigations->count() > 0)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Investigações Encontradas ({{ $investigations->count() }})</h3>
                <ul class="mt-4 list-disc list-inside">
                    @foreach($investigations as $investigation)
                    <li>
                        <a href="{{ route('investigations.show', $investigation) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ $investigation->case_name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if ($term && $people->isEmpty() && $organizations->isEmpty() && $investigations->isEmpty())
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                 <p class="text-center text-gray-500 dark:text-gray-400">Nenhum resultado encontrado.</p>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
