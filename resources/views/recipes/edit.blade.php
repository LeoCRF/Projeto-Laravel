<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-6 text-gray-800">Editar Receita</h1>
                
                {{-- Mensagem de erro --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded-lg">
                        <strong>Ops!</strong> Há alguns problemas com o que você enviou.<br><br>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulário de edição --}}
                <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Título --}}
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-semibold mb-1">Título</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $recipe->title) }}"
                                class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-indigo-200" required>
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-semibold mb-1">Descrição</label>
                        <textarea name="description" id="description" rows="3"
                                    class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-indigo-200" required>{{ old('description', $recipe->description) }}</textarea>
                    </div>

                    {{-- Ingredientes --}}
                    <div class="mb-4">
                        <label for="ingredients" class="block text-gray-700 font-semibold mb-1">Ingredientes</label>
                        <textarea name="ingredients" id="ingredients" rows="4"
                                    class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-indigo-200" required>{{ old('ingredients', $recipe->ingredients) }}</textarea>
                    </div>

                    {{-- Instruções --}}
                    <div class="mb-4">
                        <label for="instructions" class="block text-gray-700 font-semibold mb-1">Instruções</label>
                        <textarea name="instructions" id="instructions" rows="5"
                                    class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-indigo-200" required>{{ old('instructions', $recipe->instructions) }}</textarea>
                    </div>

                    {{-- Tempo de preparo --}}
                    <div class="mb-4">
                        <label for="prep_time" class="block text-gray-700 font-semibold mb-1">Tempo de preparo (minutos)</label>
                        <input type="number" name="prep_time" id="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}"
                                class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-indigo-200">
                    </div>

                    {{-- Dificuldade --}}
                    <div class="mb-4">
                        <label for="difficulty" class="block text-gray-700 font-semibold mb-1">Dificuldade</label>
                        <select name="difficulty" id="difficulty"
                                class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-indigo-200">
                            <option value="">Selecione</option>
                            <option value="Fácil" {{ old('difficulty', $recipe->difficulty) == 'Fácil' ? 'selected' : '' }}>Fácil</option>
                            <option value="Média" {{ old('difficulty', $recipe->difficulty) == 'Média' ? 'selected' : '' }}>Média</option>
                            <option value="Difícil" {{ old('difficulty', $recipe->difficulty) == 'Difícil' ? 'selected' : '' }}>Difícil</option>
                        </select>
                    </div>

                    {{-- Categoria --}}
                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 font-semibold mb-1">Categoria</label>
                        <input type="text" name="category" id="category" value="{{ old('category', $recipe->category) }}"
                                class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-indigo-200">
                    </div>

                    {{-- Sustentabilidade --}}
                    <div class="mb-4">
                        <label for="sustainability_score" class="block text-gray-700 font-semibold mb-1">Sustentabilidade (0 a 10)</label>
                        <input type="number" name="sustainability_score" id="sustainability_score" min="0" max="10"
                                value="{{ old('sustainability_score', $recipe->sustainability_score) }}"
                                class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-indigo-200">
                    </div>

                    {{-- Imagem --}}
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 font-semibold mb-1">Imagem</label>
                        @if ($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" 
                                    alt="Imagem atual" 
                                    class="rounded mb-2 w-48 h-32 object-cover">
                        @endif
                        <input type="file" name="image" id="image"
                                class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-indigo-200">
                    </div>

                    {{-- Botões --}}
                    <div class="flex justify-between">
                        <a href="{{ route('recipes.index') }}" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                            ← Cancelar
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            Atualizar Receita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
