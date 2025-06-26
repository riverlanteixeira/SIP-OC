<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalhes da Investigação') }}
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('investigations.pdf', $investigation->id) }}" target="_blank" class="inline-block rounded bg-green-600 px-4 py-2 text-xs font-medium text-white hover:bg-green-700">
                    Gerar Relatório PDF
                </a>
                <a href="{{ route('investigations.edit', $investigation->id) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                    Editar/Gerenciar Vínculos
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensagens de sucesso/erro para o upload -->
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700 dark:bg-green-900 dark:text-green-200" role="alert">
                    {{ session('success') }}
                </div>
            @endif
             @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 px-6 py-5 text-base text-red-700 dark:bg-red-900 dark:text-red-200" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Gráfico de Relacionamentos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Gráfico de Relacionamentos</h3>
                    <div id="relationshipGraph" class="h-96 border dark:border-gray-700 rounded-lg"></div>
                </div>
            </div>

            <!-- ... (Cartões de Detalhes, Pessoas, Organizações, etc., como antes) ... -->
            <!-- Detalhes do Caso, Pessoas e Organizações -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ $investigation->case_name }}</h3>
                    <p><strong class="font-semibold">Status:</strong> {{ $investigation->status }}</p>
                    <p class="mt-4"><strong class="font-semibold">Descrição:</strong></p>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $investigation->description ?? 'Nenhuma descrição fornecida.' }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pessoas Envolvidas</h3>
                    <ul class="mt-4 list-disc list-inside">
                        @forelse($investigation->people ?? [] as $person)
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Organizações Envolvidas</h3>
                    <ul class="mt-4 list-disc list-inside">
                        @forelse($investigation->organizations ?? [] as $organization)
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
            
            <!-- Documentos e Evidências -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Documentos e Evidências</h3>

                    <!-- Formulário de Upload -->
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 border-b dark:border-gray-700 pb-6">
                        @csrf
                        <input type="hidden" name="documentable_id" value="{{ $investigation->id }}">
                        <input type="hidden" name="documentable_type" value="Investigation">
                        <div>
                            <label for="document" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Anexar Novo Documento</label>
                            <input id="document" name="document" type="file" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Enviar
                            </button>
                        </div>
                    </form>

                    <!-- Lista de Documentos Anexados -->
                    <div class="mt-6">
                        <h4 class="font-medium text-gray-800 dark:text-gray-200">Ficheiros Anexados:</h4>
                        <ul class="mt-2 list-disc list-inside space-y-2">
                            @forelse($investigation->documents ?? [] as $document)
                                <li class="flex items-center justify-between py-1">
                                    <a href="{{ asset('storage/' . $document->path) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                        {{ $document->original_name }}
                                    </a>
                                    <form action="{{ route('documents.destroy', $document) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja excluir este ficheiro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-500 hover:underline text-xs font-semibold">Excluir</button>
                                    </form>
                                </li>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum documento anexado a esta investigação.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
        <script type="text/javascript">
            @if (isset($graphData) && count($graphData['nodes']) > 0)
                const graphData = {!! json_encode($graphData) !!};
                const nodes = new vis.DataSet(graphData.nodes);
                const edges = new vis.DataSet(graphData.edges);
                const container = document.getElementById('relationshipGraph');
                const data = { nodes: nodes, edges: edges, };
                const options = {
                    layout: { improvedLayout: true },
                    interaction: { dragNodes: true, dragView: true, zoomView: true, hover: true },
                    physics: {
                        enabled: true, solver: 'forceAtlas2Based',
                        forceAtlas2Based: { gravitationalConstant: -50, centralGravity: 0.01, springLength: 200, springConstant: 0.08, avoidOverlap: 0.5 },
                        stabilization: { iterations: 1000, fit: true, updateInterval: 25 }
                    }
                };
                const network = new vis.Network(container, data, options);
                network.on("stabilizationIterationsDone", function () {
                    network.setOptions( { physics: false } );
                });
            @endif
        </script>
    @endpush
</x-app-layout>
