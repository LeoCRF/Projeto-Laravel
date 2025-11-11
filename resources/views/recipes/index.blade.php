<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Receitas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensagem de sucesso --}}
            @if (session('success'))
                <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Botão para criar nova receita --}}
            <div class="mb-4 flex justify-end">
                <a href="{{ route('recipes.create') }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    + Nova Receita
                </a>
            </div>

            {{-- Listagem de receitas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($recipes as $recipe)
                    <div class="bg-white rounded-lg shadow p-4 flex flex-col">
                        @if ($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="rounded-lg mb-3 h-48 w-full object-cover">
                        @endif

                        <h3 class="text-lg font-semibold mb-1">{{ $recipe->title }}</h3>
                        <p class="text-gray-600 text-sm flex-1">{{ Str::limit($recipe->description, 100) }}</p>

                        <div class="mt-3 flex justify-between items-center">
                            <a href="{{ route('recipes.show', $recipe) }}"
                                class="text-indigo-600 hover:underline text-sm">Ver mais</a>

                            <a href="{{ route('recipes.edit', $recipe) }}"
                                class="text-yellow-600 hover:underline text-sm">Editar</a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-center col-span-3">Nenhuma receita cadastrada ainda.</p>
                @endforelse
            </div>

            {{-- Paginação --}}
            <div class="mt-6">
                {{ $recipes->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
