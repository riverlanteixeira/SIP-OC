<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Pessoa: ') }} {{ $person->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="rounded-lg bg-green-100 dark:bg-green-900 p-4 text-sm text-green-700 dark:text-green-200" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulário de Dados Pessoais e Vínculos -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Dados Pessoais e Vínculos</h3>
                <form method="POST" action="{{ route('people.update', $person->id) }}" class="mt-6">
                    @csrf
                    @method('PUT')
                    @include('people.partials.form')
                </form>
            </div>

            <!-- Gestão de Tatuagens -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Tatuagens</h3>
                <form action="{{ route('tattoos.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 border-t dark:border-gray-700 pt-6">
                    @csrf
                    <input type="hidden" name="person_id" value="{{ $person->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="body_part" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Parte do Corpo</label>
                            <select id="body_part" name="body_part" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option value="">Selecione uma parte (opcional)</option>
                                <option value="Rosto">Rosto</option>
                                <option value="Pescoço">Pescoço</option>
                                <option value="Ombro direito">Ombro direito</option>
                                <option value="Ombro esquerdo">Ombro esquerdo</option>
                                <option value="Braço direito">Braço direito</option>
                                <option value="Braço esquerdo">Braço esquerdo</option>
                                <option value="Antebraço direito">Antebraço direito</option>
                                <option value="Antebraço esquerdo">Antebraço esquerdo</option>
                                <option value="Mão direita">Mão direita</option>
                                <option value="Mão esquerda">Mão esquerda</option>
                                <option value="Peitoral">Peitoral</option>
                                <option value="Abdome">Abdome</option>
                                <option value="Costas">Costas</option>
                                <option value="Coxa direita">Coxa direita</option>
                                <option value="Coxa esquerda">Coxa esquerda</option>
                                <option value="Perna direita">Perna direita</option>
                                <option value="Perna esquerda">Perna esquerda</option>
                                <option value="Pé direito">Pé direito</option>
                                <option value="Pé esquerdo">Pé esquerdo</option>
                            </select>
                        </div>
                        <div>
                            <label for="image" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Imagem (Opcional)</label>
                            <input type="file" id="image" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Descrição</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-500">Adicionar Tatuagem</button>
                    </div>
                </form>
                <div class="mt-6 border-t dark:border-gray-700 pt-6">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200">Tatuagens Registadas:</h4>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($person->tattoos as $tattoo)
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                @if($tattoo->image_path)
                                    <img src="{{ asset('storage/' . $tattoo->image_path) }}" alt="Tatuagem" class="w-full h-40 object-cover rounded-md mb-4">
                                @endif
                                <p class="font-semibold">{{ $tattoo->body_part }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $tattoo->description }}</p>
                                <form action="{{ route('tattoos.destroy', $tattoo) }}" method="POST" class="mt-4 text-right" onsubmit="return confirm('Tem a certeza?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-xs">Excluir</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 md:col-span-3">Nenhuma tatuagem registada para esta pessoa.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Gestão de Contatos -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Contatos e Redes Sociais</h3>
                <form action="{{ route('contacts.store') }}" method="POST" class="mt-6 border-t dark:border-gray-700 pt-6">
                    @csrf
                    <input type="hidden" name="person_id" value="{{ $person->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipo de Contato</label>
                            <select id="type" name="type" class="mt-1 block w-full rounded-md shadow-sm" required>
                                <option value="Telefone">Telefone</option>
                                <option value="Email">Email</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Instagram">Instagram</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Telegram">Telegram</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                        <div>
                            <label for="value" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Contato / Utilizador</label>
                            <input type="text" id="value" name="value" class="mt-1 block w-full rounded-md shadow-sm" required>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-500">Adicionar Contato</button>
                    </div>
                </form>
                <div class="mt-6 border-t dark:border-gray-700 pt-6">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200">Contatos Registados:</h4>
                    <ul class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($person->contacts as $contact)
                            <li class="flex items-center justify-between py-2">
                                <div>
                                    <span class="font-semibold">{{ $contact->type }}:</span>
                                    <span class="text-gray-600 dark:text-gray-400 ml-2">{{ $contact->value }}</span>
                                </div>
                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Tem a certeza?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-xs">Excluir</button>
                                </form>
                            </li>
                        @empty
                            <li class="py-2 text-sm text-gray-500 dark:text-gray-400">Nenhum contato registado.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Histórico de Reclusão (CORRIGIDO: Bloco não duplicado) -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Histórico de Reclusão</h3>

                <form action="{{ route('incarcerations.store') }}" method="POST" class="mt-6 border-t dark:border-gray-700 pt-6">
                    @csrf
                    <input type="hidden" name="person_id" value="{{ $person->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="prison_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Unidade Prisional</label>
                            <select id="prison_name" name="prison_name" class="mt-1 block w-full rounded-md" required>
                                <option value="">Selecione a unidade</option>
                                @foreach($prisons as $prison)
                                    <option value="{{ $prison }}">{{ $prison }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="entry_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Data de Entrada</label>
                            <input type="date" id="entry_date" name="entry_date" class="mt-1 block w-full rounded-md" required>
                        </div>
                        <div>
                            <label for="exit_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Data de Saída (Opcional)</label>
                            <input type="date" id="exit_date" name="exit_date" class="mt-1 block w-full rounded-md">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border rounded-md font-semibold text-xs text-white uppercase">Adicionar Período</button>
                    </div>
                </form>

                <div class="mt-6 border-t dark:border-gray-700 pt-6">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200">Períodos Registados:</h4>
                    <ul class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($person->incarcerations as $incarceration)
                            <li class="flex items-center justify-between py-2">
                                <div>
                                    <span class="font-semibold">{{ $incarceration->prison_name }}</span>
                                    <span class="ml-2 text-gray-600 dark:text-gray-400"> (De {{ $incarceration->entry_date->format('d/m/Y') }} até {{ $incarceration->exit_date ? $incarceration->exit_date->format('d/m/Y') : 'presente' }})</span>
                                </div>
                                <form action="{{ route('incarcerations.destroy', $incarceration) }}" method="POST" onsubmit="return confirm('Tem a certeza?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-xs">Excluir</button>
                                </form>
                            </li>
                        @empty
                            <li class="py-2 text-sm text-gray-500 dark:text-gray-400">Nenhum período de reclusão registado.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
