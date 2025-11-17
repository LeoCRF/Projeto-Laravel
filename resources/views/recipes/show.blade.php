@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md space-y-6">
    
    {{-- Título e imagem --}}
    <div class="text-center">
        <h1 class="text-3xl font-bold mb-4">{{ $recipe->title }}</h1>
        @if($recipe->image)
            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="mx-auto rounded-lg shadow-md max-h-96 object-cover">
        @endif
    </div>

    {{-- Tempo de preparo, dificuldade, sustentabilidade e categoria --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-4 text-gray-700 font-medium">
        {{-- Tempo de preparo --}}
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a8 8 0 11-8 8 8 8 0 018-8zm1 9H9V5h2v6z"/>
            </svg>
            <span>{{ $recipe->prep_time ?? 'Não informado' }} min</span>
        </div>

        {{-- Dificuldade --}}
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a8 8 0 11-8 8 8 8 0 018-8zm1 11H9v-2h2v2z"/>
            </svg>
            <span>{{ $recipe->difficulty ?? 'Não informada' }}</span>
        </div>

        {{-- Categoria --}}
        @if($recipe->category)
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 3h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1zm0 2v10h12V5H4z"/>
                </svg>
                <span>{{ $recipe->category }}</span>
            </div>
        @endif

        {{-- Sustentabilidade --}}
        @if(!is_null($recipe->sustainability_score))
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a8 8 0 118 8c0 4.418-3.582 8-8 8s-8-3.582-8-8a8 8 0 018-8zM9 9v4h2V9H9z"/>
                </svg>
                <span>{{ $recipe->sustainability_score }}/10 Sustentável</span>
            </div>
        @endif
    </div>

    {{-- Botões Curtir e Salvar --}}
@auth
<div class="flex gap-4 mt-4">

    {{-- Curtir --}}
    <button id="like-btn" data-id="{{ $recipe->id }}" class="flex items-center gap-1 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" 
             fill="{{ $liked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
        <span id="likes-count">{{ $recipe->likedByUsers()->count() }}</span> Curtir
    </button>

    {{-- Salvar --}}
    <button id="save-btn" data-id="{{ $recipe->id }}" class="flex items-center gap-1 px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" 
             fill="{{ $saved ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h14v14H5z" />
        </svg>
        <span>{{ $saved ? 'Salvo' : 'Salvar' }}</span>
    </button>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const likeBtn = document.getElementById('like-btn');
    const saveBtn = document.getElementById('save-btn');
    const likesCount = document.getElementById('likes-count');

    // Curtir/descurtir
    likeBtn.addEventListener('click', function () {
        const recipeId = this.dataset.id;

        fetch(`/recipes/${recipeId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            // Atualiza cor do SVG e contador
            likeBtn.querySelector('svg').setAttribute('fill', data.status === 'liked' ? 'currentColor' : 'none');
            likesCount.textContent = data.likes_count;
        });
    });

    // Salvar/unsave
    saveBtn.addEventListener('click', function () {
        const recipeId = this.dataset.id;

        fetch(`/recipes/${recipeId}/save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            saveBtn.querySelector('svg').setAttribute('fill', data.status === 'saved' ? 'currentColor' : 'none');
            saveBtn.querySelector('span').textContent = data.status === 'saved' ? 'Salvo' : 'Salvar';
        });
    });
});
</script>
@endauth


    {{-- Ingredientes --}}
    <div>
        <h2 class="text-2xl font-semibold mb-2">Ingredientes</h2>
        <ul class="list-disc list-inside space-y-1">
            @forelse(explode(',', $recipe->ingredients) as $ingredient)
                <li>{{ $ingredient }}</li>
            @empty
                <li>Sem ingredientes cadastrados</li>
            @endforelse
        </ul>
    </div>

    {{-- Modo de preparo --}}
    <div>
        <h2 class="text-2xl font-semibold mb-2">Modo de preparo</h2>
        <ol class="list-decimal list-inside space-y-1">
            @forelse(explode("\n", $recipe->instructions) as $step)
                <li>{{ $step }}</li>
            @empty
                <li>Sem instruções cadastradas</li>
            @endforelse
        </ol>
    </div>

    {{-- Comentários existentes --}}
    <div>
        <h2 class="text-2xl font-semibold mb-2">Comentários</h2>
        @forelse($recipe->comments as $comment)
            <div class="border p-4 rounded-md mb-2 bg-gray-50">
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $comment->user->name ?? 'Usuário' }}</span>
                    {{-- Botões Editar/Excluir apenas se for o dono do comentário --}}
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

                {{-- Avaliação --}}
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
                <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">

                {{-- Estrelas de avaliação --}}
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

{{-- Script funcional das estrelas --}}
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
