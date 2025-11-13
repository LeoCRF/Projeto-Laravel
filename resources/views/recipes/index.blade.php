<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-slate-900 via-purple-900 to-slate-950">
        {{-- Hero Section Ultra Premium --}}
        <div class="relative overflow-hidden pt-0 pb-0 px-4 sm:px-6 lg:px-8">
            {{-- Animated background elements - FULL HEIGHT --}}
            <div class="absolute inset-0 overflow-hidden">
                {{-- Top left large blob --}}
                <div class="absolute -top-40 -left-40 w-96 h-96 bg-purple-600/30 rounded-full blur-3xl animate-pulse"></div>
                {{-- Top right blob --}}
                <div class="absolute -top-32 right-32 w-80 h-80 bg-pink-600/25 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
                {{-- Middle center blob --}}
                <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                {{-- Bottom right large blob --}}
                <div class="absolute bottom-0 -right-32 w-96 h-96 bg-purple-600/25 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s;"></div>
                {{-- Bottom left blob --}}
                <div class="absolute -bottom-40 left-20 w-80 h-80 bg-pink-600/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
            </div>

            {{-- Gradient mesh overlay --}}
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-purple-500 to-transparent opacity-60"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/50 via-transparent to-slate-950/80"></div>
            </div>

            {{-- Content with relative positioning --}}
            <div class="relative min-h-screen flex items-center justify-center">
                <div class="max-w-7xl mx-auto text-center w-full py-20 md:py-32">
                    {{-- Decorative element with enhanced glow --}}
                    <div class="inline-flex items-center justify-center mb-8 bg-gradient-to-r from-purple-600/20 to-pink-600/20 px-6 py-3 rounded-full backdrop-blur-xl border border-purple-500/30">
                        <span class="text-sm font-bold uppercase tracking-widest bg-gradient-to-r from-purple-300 to-pink-300 bg-clip-text text-transparent">
                            ✨ Bem-vindo ao SmartCook
                        </span>
                    </div>

                    {{-- Main headline with shadow effect --}}
                    <h1 class="text-7xl md:text-8xl font-black text-white mb-6 leading-tight drop-shadow-2xl">
                        Descubra
                        <br />
                        <span class="bg-gradient-to-r from-purple-400 via-pink-400 to-rose-400 bg-clip-text text-transparent animate-pulse">
                            Receitas Incríveis
                        </span>
                    </h1>

                    <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto font-light leading-relaxed drop-shadow-lg">
                        Explore, crie e compartilhe as melhores receitas com nossa comunidade culinária
                    </p>

                    {{-- CTA Buttons with enhanced effects --}}
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-20">
                        <a href="{{ route('recipes.create') }}"
                            class="group relative px-10 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold text-lg rounded-full shadow-2xl hover:shadow-purple-500/80 transition-all duration-300 hover:scale-110 hover:-translate-y-1 flex items-center gap-3 overflow-hidden border border-purple-400/50">
                            <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <span class="relative flex items-center gap-3 whitespace-nowrap">
                                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Criar Receita
                            </span>
                        </a>

                        <button class="px-10 py-4 border-2 border-purple-400 text-purple-300 font-bold text-lg rounded-full hover:bg-purple-600/20 hover:border-purple-300 transition-all duration-300 flex items-center gap-3 backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Explorar Receitas
                        </button>
                    </div>

                    {{-- Stats with glassmorphism --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto">
                        <div class="bg-gradient-to-br from-purple-600/20 to-pink-600/20 backdrop-blur-xl rounded-2xl p-6 border border-purple-500/30 hover:border-purple-400/50 transition-all hover:shadow-lg hover:shadow-purple-500/20">
                            <div class="text-5xl font-black bg-gradient-to-r from-purple-300 to-pink-300 bg-clip-text text-transparent">{{ $recipes->total() + $apiRecipes->count() }}</div>
                            <p class="text-gray-400 text-sm mt-2 uppercase tracking-wider font-semibold">Receitas</p>
                        </div>
                        <div class="bg-gradient-to-br from-pink-600/20 to-rose-600/20 backdrop-blur-xl rounded-2xl p-6 border border-pink-500/30 hover:border-pink-400/50 transition-all hover:shadow-lg hover:shadow-pink-500/20">
                            <div class="text-5xl font-black bg-gradient-to-r from-pink-300 to-rose-300 bg-clip-text text-transparent">∞</div>
                            <p class="text-gray-400 text-sm mt-2 uppercase tracking-wider font-semibold">Possibilidades</p>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-600/20 to-purple-600/20 backdrop-blur-xl rounded-2xl p-6 border border-indigo-500/30 hover:border-indigo-400/50 transition-all hover:shadow-lg hover:shadow-indigo-500/20">
                            <div class="text-5xl font-black bg-gradient-to-r from-indigo-300 to-purple-300 bg-clip-text text-transparent">⭐</div>
                            <p class="text-gray-400 text-sm mt-2 uppercase tracking-wider font-semibold">Premium</p>
                        </div>
                    </div>

                    {{-- Scroll indicator --}}
                    <div class="mt-16 flex justify-center">
                        <div class="animate-bounce">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 relative z-10 mb-8">
                <div class="bg-gradient-to-r from-emerald-500/20 to-teal-500/20 border border-emerald-500/50 rounded-xl p-4 flex items-center gap-3 backdrop-blur-sm">
                    <svg class="w-6 h-6 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-emerald-300 font-semibold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Content Section --}}
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            {{-- Section Header --}}
            <div class="mb-16">
                <div class="flex flex-col items-center justify-center mb-6">
                    <div class="inline-block">
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md rounded-full px-6 py-3 border border-white/20 mb-8">
                            <span class="text-3xl">🍳</span>
                            <span class="text-sm font-bold text-purple-300 uppercase tracking-widest">Receitas em Destaque</span>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <h2 class="text-5xl md:text-6xl font-black text-white mb-4">
                        Explore
                        <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                            Nossas Receitas
                        </span>
                    </h2>
                    <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                        Escolha entre receitas criadas pela comunidade ou descubra clássicos internacionais
                    </p>
                </div>
            </div>

            {{-- Empty State --}}
            @if ($recipes->isEmpty() && $apiRecipes->isEmpty())
                <div class="text-center py-20">
                    <div class="inline-block p-4 bg-white/5 rounded-full mb-6">
                        <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Nenhuma Receita Encontrada</h3>
                    <p class="text-gray-400 mb-6">Seja o primeiro a criar uma receita incrível!</p>
                    <a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-full hover:shadow-lg hover:shadow-purple-500/50 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Criar Receita
                    </a>
                </div>
            @else
                {{-- Recipes Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($recipes as $recipe)
                        <a href="{{ route('recipes.show', $recipe) }}" class="group h-full">
                            <div class="relative h-full bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl overflow-hidden hover:border-purple-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-purple-500/20 hover:-translate-y-2 flex flex-col">
                                {{-- Image Container --}}
                                <div class="relative h-56 bg-gradient-to-br from-purple-600 to-pink-600 overflow-hidden">
                                    @if ($recipe->image)
                                        <img src="{{ asset('storage/' . $recipe->image) }}" 
                                             alt="{{ $recipe->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-600 to-indigo-600">
                                            <svg class="w-20 h-20 opacity-30 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    {{-- Badge Difficulty --}}
                                    @if ($recipe->difficulty)
                                        <div class="absolute top-4 right-4">
                                            <span class="inline-block px-4 py-1 bg-black/60 backdrop-blur rounded-full text-xs font-bold text-white">
                                                {{ $recipe->difficulty }}
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Badge Creator --}}
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-block px-3 py-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full text-xs font-bold text-white">
                                            👤 {{ Str::limit($recipe->user->name ?? 'Você', 12) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-6 flex flex-col flex-grow">
                                    <h3 class="text-xl font-bold text-white mb-2 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-purple-400 group-hover:to-pink-400 group-hover:bg-clip-text transition-all line-clamp-2">
                                        {{ $recipe->title }}
                                    </h3>
                                    
                                    <p class="text-gray-300 text-sm flex-grow line-clamp-2 mb-4">
                                        {{ Str::limit($recipe->description, 85) }}
                                    </p>

                                    {{-- Metadata Pills --}}
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @if ($recipe->prep_time)
                                            <span class="inline-flex items-center px-3 py-1 bg-orange-500/20 text-orange-300 text-xs font-semibold rounded-full border border-orange-500/50">
                                                ⏱️ {{ $recipe->prep_time }}m
                                            </span>
                                        @endif
                                        
                                        @if ($recipe->category)
                                            <span class="inline-flex items-center px-3 py-1 bg-emerald-500/20 text-emerald-300 text-xs font-semibold rounded-full border border-emerald-500/50">
                                                🏷️ {{ Str::limit($recipe->category, 10) }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Rating --}}
                                    @php
                                        $avgRating = $recipe->comments()->whereNotNull('rating')->avg('rating');
                                    @endphp
                                    @if ($avgRating)
                                        <div class="flex items-center mb-4">
                                            <div class="flex gap-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= round($avgRating))
                                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                    @else
                                                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="ml-2 text-xs text-gray-400 font-semibold">{{ number_format($avgRating, 1) }}/5</span>
                                        </div>
                                    @endif

                                    {{-- Actions --}}
                                    <div class="flex gap-2 pt-4 border-t border-white/10">
                                        <button class="flex-1 px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-lg hover:shadow-lg hover:shadow-purple-500/50 transition-all duration-300 text-sm">
                                            Ver Receita
                                        </button>
                                        
                                        @if (Auth::id() === $recipe->user_id)
                                            <a href="{{ route('recipes.edit', $recipe) }}"
                                                class="flex-1 px-4 py-2 bg-yellow-600/30 text-yellow-300 font-bold rounded-lg hover:bg-yellow-600/50 transition-all duration-300 text-sm border border-yellow-600/50 text-center">
                                                ✏️
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        {{-- API Recipes --}}
                        @forelse ($apiRecipes as $apiRecipe)
                            @php $apiId = $apiRecipe['id'] ?? null; @endphp
                            @if ($apiId)
                                <a href="{{ route('api-recipes.show', $apiId) }}" class="group h-full">
                                    <div class="relative h-full bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl overflow-hidden hover:border-blue-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-blue-500/20 hover:-translate-y-2 flex flex-col">
                            @else
                                <div class="group h-full">
                                    <div class="relative h-full bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl overflow-hidden transition-all duration-300 flex flex-col">
                            @endif
                                    {{-- Image Container --}}
                                    <div class="relative h-56 bg-gradient-to-br from-blue-600 to-cyan-600 overflow-hidden">
                                        @if ($apiRecipe['image'])
                                            <img src="{{ $apiRecipe['image'] }}" 
                                                 alt="{{ $apiRecipe['title'] }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-600 to-cyan-600">
                                                <svg class="w-20 h-20 opacity-30 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        {{-- Badge API --}}
                                        <div class="absolute top-4 left-4">
                                            <span class="inline-block px-3 py-1 bg-blue-600 rounded-full text-xs font-bold text-white">
                                                🌐 TheMealDB
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="p-6 flex flex-col flex-grow">
                                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-blue-400 group-hover:to-cyan-400 group-hover:bg-clip-text transition-all line-clamp-2">
                                            {{ $apiRecipe['title'] }}
                                        </h3>
                                        
                                        <p class="text-gray-300 text-sm flex-grow line-clamp-2 mb-4">
                                            {{ Str::limit($apiRecipe['description'], 85) }}
                                        </p>

                                        {{-- Metadata --}}
                                        @if ($apiRecipe['category'])
                                            <span class="inline-flex items-center px-3 py-1 bg-emerald-500/20 text-emerald-300 text-xs font-semibold rounded-full border border-emerald-500/50 w-fit mb-4">
                                                🏷️ {{ Str::limit($apiRecipe['category'], 12) }}
                                            </span>
                                        @endif

                                        {{-- Button --}}
                                        <div class="pt-4 border-t border-white/10">
                                            <button class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-lg hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-300 text-sm">
                                                Ver Detalhes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @if ($apiId)
                                </div>
                                </a>
                            @else
                                </div>
                            @endif
                        @empty
                            <div class="col-span-full text-center py-20">
                                <div class="inline-block p-4 bg-white/5 rounded-full mb-6">
                                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2">Nenhuma Receita Encontrada</h3>
                                <p class="text-gray-400">Tente novamente mais tarde ou crie uma receita agora</p>
                            </div>
                        @endforelse
                    @endforelse
                </div>
            @endif

            {{-- Pagination --}}
            <div class="mt-16">
                @if ($recipes->count() > 0)
                    <div class="flex justify-center">
                        <div class="inline-block">
                            {{ $recipes->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</x-app-layout>
