@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md space-y-6">

    {{-- Título e imagem --}}
    <div class="text-center">
        <h1 class="text-3xl font-bold mb-4">{{ $recipe->title }}</h1>
        @if($recipe->image)
            <img src="{{ $recipe->image && str_starts_with($recipe->image, 'http') ? $recipe->image : asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="mx-auto rounded-lg shadow-md max-h-96 object-cover">
        @endif
        @if(isset($recipe->category))
            <p class="text-emerald-500 font-semibold mt-2">{{ $recipe->category }}</p>
        @endif
    </div>

    {{-- Avaliação média --}}
    <div class="flex items-center justify-center space-x-2">
        @php
            $avgRating = count($comments) > 0 ? round($comments->avg('rating'), 1) : null;
        @endphp
        @if($avgRating)
            <div class="flex items-center">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09L5.642 12 1 7.91l6.061-.88L10 2l2.939 5.03 6.061.88L14.358 12l1.52 6.09z"/>
                    </svg>
                @endfor
                <span class="ml-2 text-gray-700 font-medium">({{ $avgRating }})</span>
            </div>
        @else
            <span class="text-gray-500">Sem avaliações ainda</span>
        @endif
    </div>

    {{-- Ingredientes --}}
    <div>
        <h2 class="text-2xl font-semibold mb-2">Ingredientes</h2>
        @if(is_array($recipe->ingredients))
            <ul class="list-disc list-inside text-gray-700">
                @foreach($recipe->ingredients as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-700">{{ $recipe->ingredients }}</p>
        @endif
    </div>

    {{-- Modo de Preparo --}}
    <div>
        <h2 class="text-2xl font-semibold mb-2">Modo de preparo</h2>
        @if(is_array($recipe->instructions))
            <ol class="list-decimal list-inside text-gray-700">
                @foreach($recipe->instructions as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </ol>
        @else
            <p class="text-gray-700">{{ $recipe->instructions }}</p>
        @endif
    </div>

    {{-- Botões Editar/Excluir receita --}}
    @auth
        @if(isset($recipe->user_id) && Auth::id() === $recipe->user_id)
            <div class="flex gap-2 mt-4">
                <a href="{{ route('recipes.edit', $recipe->id) }}" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">Editar</a>
                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Excluir</button>
                </form>
            </div>
        @endif
    @endauth

    {{-- Comentários existentes --}}
    <div>
        <h2 class="text-2xl font-semibold mb-2">Comentários</h2>
        @forelse($comments as $comment)
            <div class="border p-4 rounded-md mb-2 bg-gray-50">
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $comment->user->name ?? 'Usuário' }}</span>

                    {{-- Botões Editar/Excluir comentário --}}
                    @auth
                        @if(Auth::id() === $comment->user_id)
                            <div class="flex gap-2">
                                <a href="{{ route('comments.edit', $comment->id) }}" class="text-blue-500 hover:underline">Editar</a>
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Excluir</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>

                @if($comment->rating)
                    <div class="flex mt-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09L5.642 12 1 7.91l6.061-.88L10 2l2.939 5.03 6.061.88L14.358 12l1.52 6.09z"/>
                            </svg>
                        @endfor
                    </div>
                @endif

                <p class="mt-1 text-gray-700">{{ $comment->content }}</p>
            </div>
        @empty
            <p class="text-gray-500">Nenhum comentário ainda.</p>
        @endforelse
    </div>

    {{-- Formulário de comentário --}}
    @auth
        <div class="mt-4">
            <h2 class="text-2xl font-semibold mb-2">Deixe seu comentário</h2>
            <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="recipe_id" value="{{ isset($recipe->user_id) ? $recipe->id : '' }}">
                <input type="hidden" name="api_recipe_id" value="{{ isset($recipe->user_id) ? '' : $recipe->id }}">

                {{-- Estrelas interativas --}}
                <div class="flex items-center gap-2">
                    <span class="mr-2 font-semibold">Nota:</span>
                    <div id="rating-stars" class="flex cursor-pointer">
                        @for($i = 1; $i <= 5; $i++)
                            <svg data-value="{{ $i }}" class="w-6 h-6 text-gray-300 hover:text-yellow-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09L5.642 12 1 7.91l6.061-.88L10 2l2.939 5.03 6.061.88L14.358 12l1.52 6.09z"/>
                            </svg>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="">
                </div>

                <textarea name="content" rows="3" class="w-full border rounded-md p-2" placeholder="Escreva seu comentário"></textarea>

                <button type="submit" class="px-4 py-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500 transition">
                    Enviar
                </button>
            </form>
        </div>
    @else
        <p class="text-gray-500">Faça login para comentar e avaliar a receita.</p>
    @endauth
</div>

{{-- Script das estrelas --}}
<script>
const stars = document.querySelectorAll('#rating-stars svg');
const input = document.getElementById('rating-input');

stars.forEach(star => {
    star.addEventListener('mouseover', () => {
        highlightStars(parseInt(star.dataset.value));
    });
    star.addEventListener('mouseout', () => {
        highlightStars(parseInt(input.value) || 0);
    });
    star.addEventListener('click', () => {
        input.value = parseInt(star.dataset.value);
        highlightStars(parseInt(input.value));
    });
});

function highlightStars(value) {
    stars.forEach(star => {
        if (parseInt(star.dataset.value) <= value) {
            star.classList.add('text-yellow-400');
            star.classList.remove('text-gray-300');
        } else {
            star.classList.add('text-gray-300');
            star.classList.remove('text-yellow-400');
        }
    });
}
</script>
@endsection
