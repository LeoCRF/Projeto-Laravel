<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Receita: {{ $recipe->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Título --}}
                    <div class="mb-4">
                        <x-input-label for="title" value="Título" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title', $recipe->title) }}" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-4">
                        <x-input-label for="description" value="Descrição" />
                        <textarea id="description" name="description" class="w-full border-gray-300 rounded-md shadow-sm mt-1">{{ old('description', $recipe->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- Ingredientes --}}
                    <div class="mb-4">
                        <x-input-label for="ingredients" value="Ingredientes" />
                        <textarea id="ingredients" name="ingredients" class="w-full border-gray-300 rounded-md shadow-sm mt-1" rows="4" required>{{ old('ingredients', $recipe->ingredients) }}</textarea>
                        <x-input-error :messages="$errors->get('ingredients')" class="mt-2" />
                    </div>

                    {{-- Instruções --}}
                    <div class="mb-4">
                        <x-input-label for="instructions" value="Modo de preparo" />
                        <textarea id="instructions" name="instructions" class="w-full border-gray-300 rounded-md shadow-sm mt-1" rows="5" required>{{ old('instructions', $recipe->instructions) }}</textarea>
                        <x-input-error :messages="$errors->get('instructions')" class="mt-2" />
                    </div>

                    {{-- Tempo de preparo --}}
                    <div class="mb-4">
                        <x-input-label for="prep_time" value="Tempo de preparo (minutos)" />
                        <x-text-input id="prep_time" name="prep_time" type="number" class="mt-1 block w-full" value="{{ old('prep_time', $recipe->prep_time) }}" />
                    </div>

                    {{-- Dificuldade --}}
                    <div class="mb-4">
                        <x-input-label for="difficulty" value="Dificuldade" />
                        <select id="difficulty" name="difficulty" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Selecione</option>
                            <option value="fácil" {{ old('difficulty', $recipe->difficulty) == 'fácil' ? 'selected' : '' }}>Fácil</option>
                            <option value="médio" {{ old('difficulty', $recipe->difficulty) == 'médio' ? 'selected' : '' }}>Médio</option>
                            <option value="difícil" {{ old('difficulty', $recipe->difficulty) == 'difícil' ? 'selected' : '' }}>Difícil</option>
                        </select>
                    </div>

                    {{-- Categoria --}}
                    <div class="mb-4">
                        <x-input-label for="category" value="Categoria" />
                        <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" value="{{ old('category', $recipe->category) }}" />
                    </div>

                    {{-- Pontuação de sustentabilidade --}}
                    <div class="mb-4">
                        <x-input-label for="sustainability_score" value="Pontuação de sustentabilidade (0 a 10)" />
                        <x-text-input id="sustainability_score" name="sustainability_score" type="number" min="0" max="10" class="mt-1 block w-full" value="{{ old('sustainability_score', $recipe->sustainability_score) }}" />
                    </div>

                    {{-- Imagem --}}
                    <div class="mb-4">
                        <x-input-label for="image" value="Imagem da receita" />
                        @if ($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="Imagem atual" class="w-48 h-32 object-cover rounded-md mb-2">
                        @endif
                        <input id="image" name="image" type="file" class="block w-full text-sm text-gray-600" accept="image/*" />
                    </div>

                    {{-- Botões --}}
                    <div class="flex justify-between items-center">
                        <a href="{{ route('recipes.index') }}" class="text-gray-600 hover:underline">← Voltar</a>
                        <x-primary-button>Atualizar Receita</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
