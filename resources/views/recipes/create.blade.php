<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Nova Receita') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                {{-- Mensagem de erro --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded-lg">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Título --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Título</label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-200">
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Descrição</label>
                        <textarea name="description" rows="3" 
                                    class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-200">{{ old('description') }}</textarea>
                    </div>

                    {{-- Ingredientes --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Ingredientes</label>
                        <textarea name="ingredients" rows="3" 
                                    class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-200">{{ old('ingredients') }}</textarea>
                    </div>

                    {{-- Instruções --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Instruções</label>
                        <textarea name="instructions" rows="3" 
                                    class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-200">{{ old('instructions') }}</textarea>
                    </div>

                    {{-- Tempo de Preparo --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Tempo de Preparo (minutos)</label>
                        <input type="number" name="prep_time" value="{{ old('prep_time') }}" 
                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-200">
                    </div>

                    {{-- Dificuldade --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Dificuldade</label>
                        <select name="difficulty" 
                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-200">
                            <option value="">Selecione uma dificuldade</option>
                            <option value="Fácil" {{ old('difficulty') == 'Fácil' ? 'selected' : '' }}>Fácil</option>
                            <option value="Média" {{ old('difficulty') == 'Média' ? 'selected' : '' }}>Média</option>
                            <option value="Difícil" {{ old('difficulty') == 'Difícil' ? 'selected' : '' }}>Difícil</option>
                        </select>
                    </div>

                    {{-- Categoria --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Categoria</label>
                        <input type="text" name="category" value="{{ old('category') }}" 
                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-200"
                                placeholder="Ex: Sobremesa, Prato Principal, etc">
                    </div>

                    {{-- Pontuação de Sustentabilidade --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Pontuação de Sustentabilidade (0-10)</label>
                        <input type="number" name="sustainability_score" value="{{ old('sustainability_score') }}" 
                                min="0" max="10"
                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-200">
                    </div>

                    {{-- Imagem --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Imagem</label>
                        <input type="file" name="image" 
                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-200">
                    </div>

                    {{-- Botões --}}
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('recipes.index') }}" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                            Cancelar
                        </a>

                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            Salvar Receita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
