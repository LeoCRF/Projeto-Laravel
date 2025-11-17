@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-4">Editar Comentário</h1>

    <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="content" class="block font-medium mb-1">Comentário:</label>
            <textarea name="content" id="content" rows="4" class="w-full border rounded-md p-2">{{ old('content', $comment->content) }}</textarea>
        </div>

        <div class="flex items-center gap-2">
            <span class="font-semibold">Nota:</span>
            <div id="rating-stars" class="flex cursor-pointer">
                @for($i = 1; $i <= 5; $i++)
                    <svg data-value="{{ $i }}" class="w-6 h-6 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09L5.642 12 1 7.91l6.061-.88L10 2l2.939 5.03 6.061.88L14.358 12l1.52 6.09z"/>
                    </svg>
                @endfor
            </div>
            <input type="hidden" name="rating" id="rating-input" value="{{ $comment->rating }}">
        </div>

        <button type="submit" class="px-4 py-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500 transition">
            Atualizar
        </button>
    </form>
</div>

<script>
const stars = document.querySelectorAll('#rating-stars svg');
const input = document.getElementById('rating-input');

stars.forEach(star => {
    star.addEventListener('mouseover', () => highlightStars(parseInt(star.dataset.value)));
    star.addEventListener('mouseout', () => highlightStars(parseInt(input.value) || 0));
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
