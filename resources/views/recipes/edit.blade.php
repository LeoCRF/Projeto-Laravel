@extends('layouts.app')

@section('title', 'Editar Receita')

@section('content')
<div class="max-w-4xl mx-auto py-20">
    <h1 class="text-4xl font-bold text-white mb-8 text-center">Editar Receita</h1>

    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data" class="bg-zinc-800/40 p-8 rounded-2xl shadow-lg border border-zinc-700">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div class="mb-6">
            <label for="title" class="block text-white font-semibold mb-2">Título</label>
            <input type="text" name="title" id="title" value="{{ old('title', $recipe->title) }}"
                   class="w-full px-4 py-2 rounded-lg bg-zinc-900 text-white border border-zinc-600 focus:border-emerald-500 focus:outline-none">
        </div>

        <!-- Descrição -->
        <div class="mb-6">
            <label for="description" class="block text-white font-semibold mb-2">Descrição</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full px-4 py-2 rounded-lg bg-zinc-900 text-white border border-zinc-600 focus:border-emerald-500 focus:outline-none">{{ old('description', $recipe->description) }}</textarea>
        </div>

        <!-- Ingredientes -->
        <div class="mb-6">
            <label for="ingredients" class="block text-white font-semibold mb-2">Ingredientes (separados por vírgula)</label>
            <textarea name="ingredients" id="ingredients" rows="3"
                      class="w-full px-4 py-2 rounded-lg bg-zinc-900 text-white border border-zinc-600 focus:border-emerald-500 focus:outline-none">{{ old('ingredients', $recipe->ingredients) }}</textarea>
        </div>

        <!-- Modo de Preparo / Instruções -->
        <div class="mb-6">
            <label for="instructions" class="block text-white font-semibold mb-2">Modo de Preparo</label>
            <textarea name="instructions" id="instructions" rows="5"
                      class="w-full px-4 py-2 rounded-lg bg-zinc-900 text-white border border-zinc-600 focus:border-emerald-500 focus:outline-none">{{ old('instructions', $recipe->instructions) }}</textarea>
        </div>

        <!-- Categoria -->
        <div class="mb-6">
            <label for="category" class="block text-white font-semibold mb-2">Categoria</label>
            <input type="text" name="category" id="category" value="{{ old('category', $recipe->category) }}"
                   class="w-full px-4 py-2 rounded-lg bg-zinc-900 text-white border border-zinc-600 focus:border-emerald-500 focus:outline-none">
        </div>

        <!-- Tempo de Preparo -->
        <div class="mb-6">
            <label for="prep_time" class="block text-white font-semibold mb-2">Tempo de Preparo (minutos)</label>
            <input type="number" name="prep_time" id="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}"
                   class="w-full px-4 py-2 rounded-lg bg-zinc-900 text-white border border-zinc-600 focus:border-emerald-500 focus:outline-none">
        </div>

        <!-- Dificuldade -->
        <div class="mb-6">
            <label for="difficulty" class="block text-white font-semibold mb-2">Dificuldade</label>
            <select name="difficulty" id="difficulty"
                    class="w-full px-4 py-2 rounded-lg bg-zinc-900 text-white border border-zinc-600 focus:border-emerald-500 focus:outline-none">
                <option value="">Selecione</option>
                <option value="Fácil" {{ old('difficulty', $recipe->difficulty) == 'Fácil' ? 'selected' : '' }}>Fácil</option>
                <option value="Médio" {{ old('difficulty', $recipe->difficulty) == 'Médio' ? 'selected' : '' }}>Médio</option>
                <option value="Difícil" {{ old('difficulty', $recipe->difficulty) == 'Difícil' ? 'selected' : '' }}>Difícil</option>
            </select>
        </div>

        <!-- Pontuação de Sustentabilidade -->
        <div class="mb-6">
            <label for="sustainability_score" class="block text-white font-semibold mb-2">Pontuação de Sustentabilidade (0 a 10)</label>
            <input type="number" name="sustainability_score" id="sustainability_score" min="0" max="10" value="{{ old('sustainability_score', $recipe->sustainability_score) }}"
                   class="w-full px-4 py-2 rounded-lg bg-zinc-900 text-white border border-zinc-600 focus:border-emerald-500 focus:outline-none">
        </div>

        <!-- Imagem Atual -->
        @if($recipe->image)
        <div class="mb-6">
            <label class="block text-white font-semibold mb-2">Imagem Atual</label>
            <img src="{{ asset('storage/' . $recipe->image) }}" alt="Imagem da Receita" class="w-64 h-40 object-cover rounded-lg mb-2">
        </div>
        @endif

        <!-- Nova Imagem -->
        <div class="mb-6">
            <label for="image" class="block text-white font-semibold mb-2">Alterar Imagem</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-full text-white">
        </div>

        <!-- Botões -->
        <div class="flex justify-between items-center">
            <a href="{{ route('recipes.index') }}" class="px-6 py-3 bg-zinc-600 text-white font-semibold rounded-lg hover:bg-zinc-700 transition">Cancelar</a>
            <button type="submit" class="px-6 py-3 bg-emerald-500 text-white font-semibold rounded-lg hover:bg-emerald-600 transition">Atualizar Receita</button>
        </div>
    </form>
</div>
@endsection
