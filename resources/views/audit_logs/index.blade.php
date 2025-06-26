<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trilha de Auditoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Data</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Utilizador</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Ação</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 dark:text-white">Registo Afetado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($logs as $log)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 dark:text-gray-200">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 dark:text-gray-200">{{ $log->user->name ?? 'Sistema' }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($log->action == 'created') bg-green-100 text-green-800 @endif
                                            @if($log->action == 'updated') bg-yellow-100 text-yellow-800 @endif
                                            @if($log->action == 'deleted') bg-red-100 text-red-800 @endif
                                        ">
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 dark:text-gray-200">
                                        {{-- Extrai o nome curto da classe, ex: 'App\Models\Person' -> 'Person' --}}
                                        @php $modelName = class_basename($log->auditable_type); @endphp
                                        {{ $modelName }} #{{ $log->auditable_id }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                        Nenhuma atividade registada.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
