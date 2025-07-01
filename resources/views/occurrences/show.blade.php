<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">{{ __('Detalhes da Ocorrência: ') }} {{ $occurrence->bo_number }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="rounded-lg bg-green-100 p-4 text-sm text-green-700" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Detalhes da Ocorrência -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="border-t border-gray-200 dark:border-gray-700">
                    <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nº do B.O.</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $occurrence->bo_number }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data do Fato</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $occurrence->fact_date->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Local do Fato</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                @if($occurrence->location)
                                    <a href="{{-- route('locations.show', $occurrence->location) --}}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                        {{ $occurrence->location->name }} ({{ $occurrence->location->city }})
                                    </a>
                                @else
                                    Não especificado
                                @endif
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Relato Geral</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">{{ $occurrence->report }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Envolvidos na Ocorrência</h3>

                <!-- Formulário para Adicionar Envolvido -->
                <form action="{{ route('occurrences.people.store') }}" method="POST" class="mt-6 border-t dark:border-gray-700 pt-6">
                    @csrf
                    <input type="hidden" name="occurrence_id" value="{{ $occurrence->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="person_id" class="block font-medium text-sm">Pessoa</label>
                            <select id="person_id" name="person_id" class="mt-1 block w-full rounded-md shadow-sm" required>
                                <option value="">Selecione uma pessoa...</option>
                                @foreach($people as $person)
                                    <option value="{{ $person->id }}">{{ $person->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="participation_type" class="block font-medium text-sm">Tipo de Participação</label>
                            <select id="participation_type" name="participation_type" class="mt-1 block w-full rounded-md shadow-sm" required>
                                <option value="Suspeito">Suspeito</option>
                                <option value="Vítima">Vítima</option>
                                <option value="Testemunha">Testemunha</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="individual_report" class="block font-medium text-sm">Relato Individual (Opcional)</label>
                        <textarea id="individual_report" name="individual_report" rows="3" class="mt-1 block w-full rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border rounded-md font-semibold text-xs text-white uppercase">Adicionar Envolvido</button>
                    </div>
                </form>

                <!-- Lista de Envolvidos -->
                <div class="mt-6 border-t dark:border-gray-700 pt-6">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200">Pessoas Vinculadas:</h4>
                    <div class="mt-2 space-y-4">
                        @forelse ($occurrence->people as $person)
                            <div class="p-3 border rounded-md">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <a href="{{ route('people.show', $person) }}" class="font-semibold text-indigo-600 hover:underline">{{ $person->full_name }}</a>
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-800">{{ $person->pivot->participation_type }}</span>
                                    </div>
                                    <form action="{{ route('occurrences.people.destroy', ['occurrence' => $occurrence, 'person' => $person]) }}" method="POST" onsubmit="return confirm('Tem a certeza?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-xs">Remover</button>
                                    </form>
                                </div>
                                @if($person->pivot->individual_report)
                                <p class="mt-2 text-sm text-gray-600 border-t pt-2">{{ $person->pivot->individual_report }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Nenhuma pessoa vinculada a esta ocorrência.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- NOVA SEÇÃO: Fatos Comunicados -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Fatos Comunicados (Tipificação)</h3>

                <!-- Formulário para Adicionar Fato -->
                <form action="{{ route('occurrences.crime-types.store') }}" method="POST" class="mt-6 border-t dark:border-gray-700 pt-6">
                    @csrf
                    <input type="hidden" name="occurrence_id" value="{{ $occurrence->id }}">
                    <div class="flex items-end space-x-4">
                        <div class="flex-grow">
                            <label for="crime_type_id" class="block font-medium text-sm">Adicionar Tipificação Penal</label>
                            <select id="crime_type_id" name="crime_type_id" class="mt-1 block w-full rounded-md shadow-sm" required>
                                <option value="">Selecione um tipo de crime...</option>
                                @foreach($crimeTypes as $crimeType)
                                    <option value="{{ $crimeType->id }}">{{ $crimeType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border rounded-md font-semibold text-xs text-white uppercase">Adicionar</button>
                    </div>
                </form>

                <!-- Lista de Fatos Vinculados -->
                <div class="mt-6">
                    <div class="flex flex-wrap gap-2">
                        @forelse ($occurrence->crimeTypes as $crimeType)
                            <div class="flex items-center bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                <span>{{ $crimeType->name }}</span>
                                <form action="{{ route('occurrences.crime-types.destroy', ['occurrence' => $occurrence, 'crimeType' => $crimeType]) }}" method="POST" class="ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">&times;</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Nenhum fato comunicado para esta ocorrência.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- NOVA SEÇÃO: Anexos da Ocorrência -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Anexos da Ocorrência</h3>

                <!-- Formulário de Upload -->
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 border-t dark:border-gray-700 pt-6">
                    @csrf
                    <input type="hidden" name="documentable_id" value="{{ $occurrence->id }}">
                    <input type="hidden" name="documentable_type" value="Occurrence">

                    <div>
                        <label for="document" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Anexar Novo Ficheiro</label>
                        <input id="document" name="document" type="file" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" required>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border rounded-md font-semibold text-xs text-white uppercase">Enviar Anexo</button>
                    </div>
                </form>

                <!-- Lista de Anexos -->
                <div class="mt-6 border-t dark:border-gray-700 pt-6">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200">Ficheiros Anexados:</h4>
                    <ul class="mt-2 list-disc list-inside space-y-2">
                        @forelse($occurrence->documents as $document)
                            <li class="flex items-center justify-between py-1">
                                <a href="{{ asset('storage/' . $document->path) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $document->original_name }}
                                </a>
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja excluir este ficheiro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-xs font-semibold">Excluir</button>
                                </form>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum anexo para esta ocorrência.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- NOVA SEÇÃO: Veículos Envolvidos -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Veículos Envolvidos</h3>

                <!-- Formulário para Adicionar Veículo -->
                <form action="{{ route('occurrences.vehicles.store') }}" method="POST" class="mt-6 border-t dark:border-gray-700 pt-6">
                    @csrf
                    <input type="hidden" name="occurrence_id" value="{{ $occurrence->id }}">
                    <div class="flex items-end space-x-4">
                        <div class="flex-grow">
                            <label for="vehicle_id" class="block font-medium text-sm">Adicionar Veículo</label>
                            <select id="vehicle_id" name="vehicle_id" class="mt-1 block w-full rounded-md shadow-sm" required>
                                <option value="">Selecione um veículo pela placa...</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->plate }} - {{ $vehicle->brand }} {{ $vehicle->model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border rounded-md font-semibold text-xs text-white uppercase">Adicionar</button>
                    </div>
                </form>

                <!-- Lista de Veículos Vinculados -->
                <div class="mt-6">
                    <div class="flex flex-wrap gap-2">
                        @forelse ($occurrence->vehicles as $vehicle)
                            <div class="flex items-center bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                <a href="{{ route('vehicles.edit', $vehicle) }}" class="hover:underline">{{ $vehicle->plate }}</a>
                                <form action="{{ route('occurrences.vehicles.destroy', ['occurrence' => $occurrence, 'vehicle' => $vehicle]) }}" method="POST" class="ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">&times;</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Nenhum veículo vinculado a esta ocorrência.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- NOVA SEÇÃO: Contas Bancárias Vinculadas -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium">Contas Bancárias Vinculadas</h3>
                <form action="{{ route('occurrences.bank-accounts.store') }}" method="POST" class="mt-6 border-t pt-6">
                    @csrf
                    <input type="hidden" name="occurrence_id" value="{{ $occurrence->id }}">
                    <div class="flex items-end space-x-4">
                        <div class="flex-grow">
                            <label for="bank_account_id" class="block font-medium text-sm">Adicionar Conta Bancária</label>
                            <select id="bank_account_id" name="bank_account_id" class="mt-1 block w-full rounded-md" required>
                                <option value="">Selecione uma conta...</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->bank_name }} - {{ $account->account_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-xs uppercase">Adicionar</button>
                    </div>
                </form>
                <div class="mt-6">
                    <div class="flex flex-wrap gap-2">
                        @forelse ($occurrence->bankAccounts as $account)
                            <div class="flex items-center bg-gray-200 rounded-full px-3 py-1 text-sm">
                                <span>{{ $account->bank_name }} - {{ $account->account_number }}</span>
                                <form action="{{ route('occurrences.bank-accounts.destroy', ['occurrence' => $occurrence, 'bankAccount' => $account]) }}" method="POST" class="ml-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500">&times;</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Nenhuma conta bancária vinculada.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- NOVA SEÇÃO: Carteiras de Criptomoedas Vinculadas -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium">Carteiras de Criptomoedas Vinculadas</h3>
                <form action="{{ route('occurrences.crypto-wallets.store') }}" method="POST" class="mt-6 border-t pt-6">
                    @csrf
                    <input type="hidden" name="occurrence_id" value="{{ $occurrence->id }}">
                    <div class="flex items-end space-x-4">
                        <div class="flex-grow">
                            <label for="crypto_wallet_id" class="block font-medium text-sm">Adicionar Carteira Cripto</label>
                            <select id="crypto_wallet_id" name="crypto_wallet_id" class="mt-1 block w-full rounded-md" required>
                                <option value="">Selecione uma carteira...</option>
                                @foreach($cryptoWallets as $wallet)
                                    <option value="{{ $wallet->id }}">{{ $wallet->coin_type }} - {{ Str::limit($wallet->address, 30) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-xs uppercase">Adicionar</button>
                    </div>
                </form>
                <div class="mt-6">
                    <div class="flex flex-wrap gap-2">
                        @forelse ($occurrence->cryptoWallets as $wallet)
                            <div class="flex items-center bg-gray-200 rounded-full px-3 py-1 text-sm">
                                <span>{{ $wallet->coin_type }}</span>
                                <form action="{{ route('occurrences.crypto-wallets.destroy', ['occurrence' => $occurrence, 'cryptoWallet' => $wallet]) }}" method="POST" class="ml-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500">&times;</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Nenhuma carteira cripto vinculada.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Secções futuras para Envolvidos, etc. -->

        </div>
    </div>
</x-app-layout>
