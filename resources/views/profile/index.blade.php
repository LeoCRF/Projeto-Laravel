@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow-md space-y-6">

    {{-- Seção do usuário --}}
    <div class="flex items-center gap-6">
        {{-- Avatar --}}
        <div>
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-gray-300">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-bold">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
            @endif
        </div>
        {{-- Nome e email --}}
        <div>
            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
            <p class="text-gray-500">{{ $user->email }}</p>
            <a href="{{ route('profile.edit') }}" class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                Editar Perfil
            </a>
        </div>
    </div>

    {{-- Abas: Minhas receitas, Curtidas, Salvas --}}
    <div>
        <ul class="flex border-b mb-4" id="tabs">
            <li class="mr-4">
                <button class="tab-link px-4 py-2 font-medium text-blue-600 border-b-2 border-blue-600" data-tab="my-recipes">Minhas Receitas</button>
            </li>
            <li class="mr-4">
                <button class="tab-link px-4 py-2 font-medium text-gray-500 hover:text-blue-600" data-tab="liked-recipes">Curtidas</button>
            </li>
            <li>
                <button class="tab-link px-4 py-2 font-medium text-gray-500 hover:text-blue-600" data-tab="saved-recipes">Salvas</button>
            </li>
        </ul>

        {{-- Conteúdo das abas --}}
        <div id="tab-contents">
            {{-- Minhas Receitas --}}
            <div class="tab-content" id="my-recipes">
                @if($myRecipes->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($myRecipes as $recipe)
                            <div class="border rounded-lg overflow-hidden shadow hover:shadow-md transition">
                                @if($recipe->image)
                                    <img src="{{ asset('storage/' . $recipe->image) }}" class="w-full h-36 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg">{{ $recipe->title }}</h3>
                                    <p class="text-gray-500 text-sm truncate">{{ $recipe->description }}</p>
                                    <a href="{{ route('recipes.show', $recipe->id) }}" class="mt-2 inline-block text-blue-500 hover:underline">Ver Receita</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Você ainda não criou nenhuma receita.</p>
                @endif
            </div>

            {{-- Curtidas --}}
            <div class="tab-content hidden" id="liked-recipes">
                @if($likedRecipes->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($likedRecipes as $recipe)
                            <div class="border rounded-lg overflow-hidden shadow hover:shadow-md transition">
                                @if($recipe->image)
                                    <img src="{{ asset('storage/' . $recipe->image) }}" class="w-full h-36 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg">{{ $recipe->title }}</h3>
                                    <p class="text-gray-500 text-sm truncate">{{ $recipe->description }}</p>
                                    <a href="{{ route('recipes.show', $recipe->id) }}" class="mt-2 inline-block text-blue-500 hover:underline">Ver Receita</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Você ainda não curtiu nenhuma receita.</p>
                @endif
            </div>

            {{-- Salvas --}}
            <div class="tab-content hidden" id="saved-recipes">
                @if($savedRecipes->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($savedRecipes as $recipe)
                            <div class="border rounded-lg overflow-hidden shadow hover:shadow-md transition">
                                @if($recipe->image)
                                    <img src="{{ asset('storage/' . $recipe->image) }}" class="w-full h-36 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg">{{ $recipe->title }}</h3>
                                    <p class="text-gray-500 text-sm truncate">{{ $recipe->description }}</p>
                                    <a href="{{ route('recipes.show', $recipe->id) }}" class="mt-2 inline-block text-blue-500 hover:underline">Ver Receita</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Você ainda não salvou nenhuma receita.</p>
                @endif
            </div>
        </div>
    </div>

</div>

{{-- Script das abas --}}
<script>
const tabs = document.querySelectorAll('#tabs .tab-link');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const target = tab.dataset.tab;

        // Resetar classes de todas as abas
        tabs.forEach(t => {
            t.classList.remove('text-blue-600', 'border-blue-600', 'border-b-2');
            t.classList.add('text-gray-500');
        });

        // Ativar a aba clicada
        tab.classList.remove('text-gray-500');
        tab.classList.add('text-blue-600', 'border-blue-600', 'border-b-2');

        // Ocultar todo conteúdo
        contents.forEach(c => c.classList.add('hidden'));

        // Mostrar aba escolhida
        document.getElementById(target).classList.remove('hidden');
    });
});
</script>
@endsection
