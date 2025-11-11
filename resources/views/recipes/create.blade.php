<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Nova Receita') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                {{-- Mensagens de erro --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg">
                        <strong>Erro:</strong> Por favor, corrija os campos abaixo.
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Título --}}
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Título')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title') }}" required />
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Descrição')" />
                        <textarea id="description" name="description" rows="3" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    </div>

                    {{-- Ingredientes --}}
                    <div class="mb-4">
                        <x-input-label for="ingredients" :value="__('Ingredientes')" />
                        <textarea id="ingredients" name="ingredients" rows="3" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('ingredients') }}</textarea>
                    </div>

                    {{-- Modo de Preparo --}}
                    <div class="mb-4">
                        <x-input-label for="instructions" :value="__('Modo de Preparo')" />
                        <textarea id="instructions" name="instructions" rows="4" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('instructions') }}</textarea>
                    </div>

                    {{-- Tempo de preparo --}}
                    <div class="mb-4">
                        <x-input-label for="prep_time" :value="__('Tempo de Preparo (minutos)')" />
                        <x-text-input id="prep_time" class="block mt-1 w-full" type="number" name="prep_time" value="{{ old('prep_time') }}" />
                    </div>

                    {{-- Dificuldade --}}
                    <div class="mb-4">
                        <x-input-label for="difficulty" :value="__('Dificuldade')" />
                        <select id="difficulty" name="difficulty" class="block w-full mt-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecione...</option>
                            <option value="fácil" {{ old('difficulty') == 'fácil' ? 'selected' : '' }}>Fácil</option>
                            <option value="médio" {{ old('difficulty') == 'médio' ? 'selected' : '' }}>Médio</option>
                            <option value="difícil" {{ old('difficulty') == 'difícil' ? 'selected' : '' }}>Difícil</option>
                        </select>
                    </div>

                    {{-- Categoria --}}
                    <div class="mb-4">
                        <x-input-label for="category" :value="__('Categoria')" />
                        <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" value="{{ old('category') }}" />
                    </div>

                    {{-- Imagem --}}
                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Imagem da Receita')" />
                        <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-700" accept="image/*">
                    </div>

                    {{-- Pontuação de sustentabilidade --}}
                    <div class="mb-4">
                        <x-input-label for="sustainability_score" :value="__('Pontuação de Sustentabilidade (0-10)')" />
                        <x-text-input id="sustainability_score" class="block mt-1 w-full" type="number" name="sustainability_score" min="0" max="10" value="{{ old('sustainability_score') }}" />
                    </div>

                    {{-- Botões --}}
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('recipes.index') }}" class="text-gray-600 hover:underline">Voltar</a>

                        <x-primary-button>
                            {{ __('Salvar Receita') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
