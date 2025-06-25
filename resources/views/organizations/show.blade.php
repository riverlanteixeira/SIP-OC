<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalhes da Organização') }}
            </h2>
            <a href="{{ route('organizations.edit', $organization->id) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                Editar Organização
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Detalhes da Organização -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ $organization->name }}</h3>
                    <p><strong class="font-semibold">Área de Atuação:</strong> {{ $organization->area_of_operation ?? 'Não informada' }}</p>
                    <p class="mt-4"><strong class="font-semibold">Descrição / Modus Operandi:</strong></p>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $organization->description ?? 'Nenhuma descrição.' }}</p>
                </div>
            </div>

            <!-- Membros Vinculados -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Membros Vinculados</h3>
                    <ul class="mt-4 list-disc list-inside">
                        @forelse($organization->people as $person)
                            {{-- Mais tarde, faremos deste nome um link para a página de detalhes da pessoa --}}
                            <li class="text-gray-600 dark:text-gray-400">{{ $person->full_name }}</li>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum membro vinculado a esta organização.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
