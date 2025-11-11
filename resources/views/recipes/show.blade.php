<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $recipe->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                {{-- Imagem da receita --}}
                @if ($recipe->image)
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="Imagem da receita" class="w-full h-64 object-cover rounded-md mb-6">
                @endif

                {{-- Informações principais --}}
                <div class="flex flex-wrap justify-between items-center mb-4">
                    <p class="text-gray-700"><strong>Autor:</strong> {{ $recipe->user->name }}</p>

                    @if ($recipe->category)
                        <p class="text-gray-700"><strong>Categoria:</strong> {{ ucfirst($recipe->category) }}</p>
                    @endif

                    @if ($recipe->difficulty)
                        <p class="text-gray-700"><strong>Dificuldade:</strong> {{ ucfirst($recipe->difficulty) }}</p>
                    @endif

                    @if ($recipe->prep_time)
                        <p class="text-gray-700"><strong>Tempo de preparo:</strong> {{ $recipe->prep_time }} min</p>
                    @endif

                    @if ($recipe->sustainability_score !== null)
                        <p class="text-gray-700"><strong>Sustentabilidade:</strong> {{ $recipe->sustainability_score }}/10</p>
                    @endif
                </div>

                {{-- Descrição --}}
                @if ($recipe->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Descrição</h3>
                        <p class="text-gray-700">{{ $recipe->description }}</p>
                    </div>
                @endif

                {{-- Ingredientes --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Ingredientes</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $recipe->ingredients }}</p>
                </div>

                {{-- Modo de preparo --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Modo de Preparo</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $recipe->instructions }}</p>
                </div>

                {{-- Botões de ação --}}
                <div class="flex justify-between">
                    <a href="{{ route('recipes.index') }}" class="text-gray-600 hover:underline">← Voltar</a>

                    @if (Auth::id() === $recipe->user_id)
                        <div class="flex gap-2">
                            <a href="{{ route('recipes.edit', $recipe) }}" class="bg-yellow-500 text-white px-3 py-2 rounded-md hover:bg-yellow-600">
                                Editar
                            </a>
                            <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta receita?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
