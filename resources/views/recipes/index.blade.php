@extends('layouts.app')

@section('title', 'Receitas')

@section('content')
<div class="relative bg-gradient-to-br from-gray-900 via-zinc-900 to-gray-800 py-20">

    <!-- Título da página -->
    <div class="text-center mb-16">
        <h1 class="text-5xl font-extrabold text-white drop-shadow-lg">Receitas</h1>
        <p class="text-gray-300 mt-3 text-lg">Confira suas receitas e nossas recomendações da API</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- MINHAS RECEITAS --}}
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl text-white font-bold border-b border-emerald-500 pb-2">Minhas Receitas</h2>

            @auth
                <a href="{{ route('recipes.create') }}" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    Criar Receita
                </a>
            @endauth
        </div>

        @if ($recipes->count() == 0)
            <p class="text-gray-400 mb-12 text-center">Você ainda não cadastrou receitas.</p>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mb-20">
            @foreach ($recipes as $recipe)
                <div class="group relative bg-zinc-800/40 rounded-3xl overflow-hidden border border-zinc-700 shadow-lg hover:shadow-emerald-600/30 transition-all duration-300">

                    <a href="{{ route('recipes.show', $recipe->id) }}">
                        <div class="h-56 w-full overflow-hidden rounded-t-3xl">
                            <img src="{{ asset('storage/' . $recipe->image) ?? '' }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>

                        <div class="p-6">
                            <h3 class="text-2xl font-semibold text-white group-hover:text-emerald-400 transition-colors">
                                {{ $recipe->title }}
                            </h3>

                            <p class="text-gray-400 mt-3 line-clamp-3 text-sm">
                                {{ $recipe->description }}
                            </p>

                            <div class="mt-5 text-sm font-semibold text-emerald-400 group-hover:underline">
                                Ver mais →
                            </div>
                        </div>
                    </a>

                    @auth
                        @if(Auth::id() === $recipe->user_id)
                            <div class="absolute top-3 right-3 flex gap-2">
                                <a href="{{ route('recipes.edit', $recipe->id) }}"
                                   class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition">
                                   Editar
                                </a>
                                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                </div>
            @endforeach
        </div>

        {{-- Paginação --}}
        <div class="flex justify-center mb-20">
            {{ $recipes->links() }}
        </div>

        {{-- RECEITAS DA API --}}
        <h2 id="api-recipes" class="text-3xl text-white font-bold mb-8 border-b border-blue-500 pb-2">Receitas da API</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 pb-10">
            @foreach ($apiRecipes as $recipe)
                <a href="{{ route('api-recipes.show', $recipe['id']) }}"
                   class="group relative bg-zinc-800/40 rounded-3xl overflow-hidden border border-zinc-700 hover:border-blue-500 transition-all duration-300 shadow-lg hover:shadow-blue-600/30">

                    <div class="h-56 w-full overflow-hidden rounded-t-3xl">
                        <img src="{{ $recipe['image'] ?? '' }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-white group-hover:text-blue-400 transition-colors">
                            {{ $recipe['title'] }}
                        </h3>

                        @if(!empty($recipe['description']))
                        <p class="text-gray-400 mt-3 line-clamp-3 text-sm">
                            {{ $recipe['description'] }}
                        </p>
                        @endif

                        <div class="mt-5 text-sm font-semibold text-blue-400 group-hover:underline">
                            Ver mais →
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</div>
@endsection
