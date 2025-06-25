<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalhes da Investigação') }}
            </h2>
            <a href="{{ route('investigations.edit', $investigation->id) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                Editar/Gerenciar Vínculos
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Gráfico de Relacionamentos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Gráfico de Relacionamentos</h3>
                    <div id="relationshipGraph" class="h-96 border dark:border-gray-700 rounded-lg"></div>
                </div>
            </div>

            <!-- Detalhes do Caso -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ $investigation->case_name }}</h3>
                    <p><strong class="font-semibold">Status:</strong> {{ $investigation->status }}</p>
                    <p class="mt-4"><strong class="font-semibold">Descrição:</strong></p>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $investigation->description ?? 'Nenhuma descrição fornecida.' }}</p>
                </div>
            </div>

            <!-- Pessoas Envolvidas com Links -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pessoas Envolvidas</h3>
                    <ul class="mt-4 list-disc list-inside">
                        @forelse($investigation->people as $person)
                            <li>
                                <a href="{{ route('people.show', $person->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $person->full_name }}
                                </a>
                                <span class="text-gray-600 dark:text-gray-400">(CPF: {{ $person->cpf ?? 'N/A' }})</span>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma pessoa vinculada a esta investigação.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Organizações Envolvidas com Links -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Organizações Envolvidas</h3>
                    <ul class="mt-4 list-disc list-inside">
                        @forelse($investigation->organizations as $organization)
                            <li>
                                <a href="{{ route('organizations.show', $organization->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $organization->name }}
                                </a>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma organização vinculada a esta investigação.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts para o Gráfico -->
    @push('scripts')
        <!-- Importar a biblioteca vis.js a partir de um CDN -->
        <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
        
        <script type="text/javascript">
            // Adiciona uma verificação para garantir que a variável $graphData existe e tem conteúdo.
            @if (isset($graphData) && count($graphData['nodes']) > 0)
                // Passar os dados do PHP (Laravel) para o JavaScript
                const graphData = {!! json_encode($graphData) !!};

                // Criar os nós e arestas para o vis.js
                const nodes = new vis.DataSet(graphData.nodes);
                const edges = new vis.DataSet(graphData.edges);

                // Container onde o gráfico será desenhado
                const container = document.getElementById('relationshipGraph');

                // Dados para o gráfico
                const data = {
                    nodes: nodes,
                    edges: edges,
                };

                // Opções de configuração do gráfico
                const options = {
                    layout: {
                        improvedLayout: true,
                    },
                    interaction: {
                        dragNodes: true,
                        dragView: true,
                        zoomView: true,
                        hover: true
                    },
                    physics: {
                        enabled: true,
                        solver: 'forceAtlas2Based',
                        forceAtlas2Based: {
                          gravitationalConstant: -50,
                          centralGravity: 0.01,
                          springLength: 200,
                          springConstant: 0.08,
                          avoidOverlap: 0.5
                        },
                        // CORREÇÃO: Adiciona opções de estabilização
                        stabilization: {
                            iterations: 1000,
                            fit: true,
                            updateInterval: 25
                        }
                    }
                };

                // Inicializar o gráfico
                const network = new vis.Network(container, data, options);

                // CORREÇÃO: Adiciona um "ouvinte" que desliga a física após a estabilização
                network.on("stabilizationIterationsDone", function () {
                    network.setOptions( { physics: false } );
                });
            @endif
        </script>
    @endpush
</x-app-layout>
