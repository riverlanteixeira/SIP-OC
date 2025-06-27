<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalhes da Pessoa') }}
            </h2>
            <a href="{{ route('people.edit', $person->id) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                Editar / Gerir Vínculos
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensagens de Sucesso -->
            @if (session('success'))
                <div class="rounded-lg bg-green-100 dark:bg-green-900 p-4 text-sm text-green-700 dark:text-green-200" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Bloco de Detalhes da Pessoa (Restaurado) -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $person->full_name }}</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Alcunha: {{ $person->nickname ?? 'N/A' }}</p>
                    </div>
                    <div class="md:text-right">
                        <p class="text-sm text-gray-600 dark:text-gray-400">ID do Sistema: {{ $person->id }}</p>
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 dark:border-gray-700">
                    <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">CPF</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $person->cpf ?? 'Não informado' }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">RG</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $person->rg ?? 'Não informado' }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Nascimento</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $person->birth_date ? $person->birth_date->format('d/m/Y') : 'Não informada' }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Filiação</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                Pai: {{ $person->father_name ?? 'Não informado' }} <br>
                                Mãe: {{ $person->mother_name ?? 'Não informado' }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Origem</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                Naturalidade: {{ $person->birth_place ?? 'Não informada' }} <br>
                                Nacionalidade: {{ $person->nationality ?? 'Não informada' }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Características</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                Sexo: {{ $person->gender ?? 'Não informado' }} <br>
                                Cor da Pele: {{ $person->skin_color ?? 'Não informada' }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Anotações</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $person->notes ?? 'Nenhuma anotação.' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Secção para VISUALIZAR Tatuagens -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Tatuagens</h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($person->tattoos as $tattoo)
                        <div class="border dark:border-gray-700 rounded-lg p-4">
                            @if($tattoo->image_path)
                                <img src="{{ asset('storage/' . $tattoo->image_path) }}" alt="Tatuagem" class="w-full h-40 object-cover rounded-md mb-4">
                            @endif
                            <p class="font-semibold">{{ $tattoo->body_part }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $tattoo->description }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400 md:col-span-3">Nenhuma tatuagem registada para esta pessoa.</p>
                    @endforelse
                </div>
            </div>

            <!-- Organizações Vinculadas -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Organizações Vinculadas</h3>
                <ul class="mt-4 list-disc list-inside">
                    @forelse($person->organizations as $organization)
                        <li>
                            <a href="{{ route('organizations.show', $organization) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $organization->name }}</a>
                            @if($organization->pivot->role)
                                <span class="text-sm text-gray-500 dark:text-gray-400"> - Função: {{ $organization->pivot->role }}</span>
                            @endif
                        </li>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">Esta pessoa não está vinculada a nenhuma organização.</p>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
