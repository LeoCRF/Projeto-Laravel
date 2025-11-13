<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Botão voltar --}}
            <a href="{{ route('recipes.index') }}" 
               class="inline-flex items-center mb-6 px-4 py-2 rounded-lg bg-white shadow-sm hover:shadow-md transition-all duration-200 text-gray-700 hover:text-indigo-600 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                {{-- Conteúdo principal (3 colunas) --}}
                <div class="lg:col-span-3 space-y-6">
                    {{-- Card principal com imagem e info --}}
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        {{-- Imagem com overlay --}}
                        <div class="relative h-80 bg-gradient-to-br from-indigo-600 to-purple-600 overflow-hidden group">
                            @if ($recipe['image'])
                                <img src="{{ $recipe['image'] }}" 
                                     alt="{{ $recipe['title'] }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-white text-lg">Sem imagem</div>
                            @endif
                            
                            {{-- Badge API --}}
                            <div class="absolute top-4 right-4">
                                <span class="inline-block px-4 py-2 bg-blue-500/95 backdrop-blur rounded-full font-semibold text-sm text-white">
                                    🌐 TheMealDB
                                </span>
                            </div>
                        </div>

                        {{-- Conteúdo --}}
                        <div class="p-8">
                            <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $recipe['title'] }}</h1>
                            <p class="text-gray-600 text-lg leading-relaxed mb-6">{{ $recipe['description'] }}</p>

                            {{-- Metadados em cards --}}
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8 -mx-2">
                                @if ($recipe['category'])
                                    <div class="px-2 py-3 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg border border-emerald-200 hover:border-emerald-300 transition-colors">
                                        <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wide">🏷️ Categoria</p>
                                        <p class="text-xl font-bold text-emerald-700 mt-1">{{ Str::limit($recipe['category'], 15) }}</p>
                                    </div>
                                @endif
                                
                                @if (!empty($recipe['tags']))
                                    <div class="px-2 py-3 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg border border-purple-200 hover:border-purple-300 transition-colors">
                                        <p class="text-xs text-purple-600 font-semibold uppercase tracking-wide">🏷️ Tags</p>
                                        <p class="text-sm font-bold text-purple-700 mt-1">{{ implode(', ', array_slice($recipe['tags'], 0, 1)) }}</p>
                                    </div>
                                @endif

                                @if ($recipe['youtube'])
                                    <div class="px-2 py-3 bg-gradient-to-br from-red-50 to-red-100 rounded-lg border border-red-200 hover:border-red-300 transition-colors">
                                        <p class="text-xs text-red-600 font-semibold uppercase tracking-wide">🎥 Vídeo</p>
                                        <a href="{{ $recipe['youtube'] }}" target="_blank" class="text-lg font-bold text-red-700 mt-1 hover:underline">Ver</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Ingredientes --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-1.5 h-10 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full mr-4"></div>
                            <h2 class="text-3xl font-bold text-gray-900">Ingredientes</h2>
                        </div>
                        <ul class="space-y-3">
                            @foreach ($recipe['ingredients'] as $ingredient)
                                <li class="flex items-start group">
                                    <span class="w-2 h-2 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                    <span class="text-gray-700 group-hover:text-gray-900 transition-colors">{{ $ingredient }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Instruções --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-1.5 h-10 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full mr-4"></div>
                            <h2 class="text-3xl font-bold text-gray-900">Modo de Preparo</h2>
                        </div>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line text-lg">{{ $recipe['instructions'] }}</p>
                    </div>

                    {{-- Comentários --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-1.5 h-10 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full mr-4"></div>
                            <h2 class="text-3xl font-bold text-gray-900">Comentários & Avaliações</h2>
                        </div>

                        {{-- Lista de comentários --}}
                        @if ($comments->isEmpty())
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="text-gray-600 text-lg">Seja o primeiro a comentar esta receita!</p>
                            </div>
                        @else
                            <div class="space-y-4 mb-8">
                                @foreach ($comments as $comment)
                                    <div class="border border-gray-200 rounded-xl p-5 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-200 group">
                                        {{-- Header do comentário --}}
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $comment->user->name ?? 'Usuário' }}</p>
                                                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>

                                            @if (Auth::id() === $comment->user_id)
                                                <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button onclick="document.getElementById('edit-comment-{{ $comment->id }}').classList.toggle('hidden')"
                                                        class="text-sm px-3 py-1 rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-colors">
                                                        Editar
                                                    </button>

                                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline" onsubmit="return confirm('Tem certeza?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-sm px-3 py-1 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                                                            Excluir
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Rating stars --}}
                                        @if ($comment->rating)
                                            <div class="flex items-center mb-2">
                                                <div class="flex text-yellow-400">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $comment->rating)
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                        @else
                                                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="ml-2 text-sm font-semibold text-gray-700">{{ $comment->rating }}/5</span>
                                            </div>
                                        @endif

                                        {{-- Conteúdo --}}
                                        @if ($comment->content)
                                            <p class="text-gray-700 leading-relaxed">{{ $comment->content }}</p>
                                        @endif

                                        {{-- Formulário de edição (escondido) --}}
                                        <div id="edit-comment-{{ $comment->id }}" class="hidden mt-4 pt-4 border-t border-gray-200">
                                            <form method="POST" action="{{ route('comments.update', $comment) }}" class="comment-edit-form space-y-3">
                                                @csrf
                                                @method('PUT')

                                                <div>
                                                    <textarea name="content" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none" placeholder="Seu comentário (opcional)">{{ old('content', $comment->content) }}</textarea>
                                                </div>

                                                <div>
                                                    <p class="text-sm font-semibold text-gray-700 mb-2">Avaliação</p>
                                                    <div class="flex items-center space-x-2 text-2xl">
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <label style="cursor:pointer" class="transition-transform hover:scale-110">
                                                                <input type="radio" name="rating" value="{{ $i }}" {{ $comment->rating == $i ? 'checked' : '' }} class="hidden">
                                                                <span class="text-yellow-400">{{ $i <= ($comment->rating ?? 0) ? '★' : '☆' }}</span>
                                                            </label>
                                                        @endfor
                                                    </div>
                                                </div>

                                                <div class="flex space-x-3">
                                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">Salvar</button>
                                                    <button type="button" onclick="document.getElementById('edit-comment-{{ $comment->id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-medium transition-colors">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Formulário de novo comentário --}}
                        @auth
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Deixe sua avaliação</h3>
                                <form method="POST" action="{{ route('comments.store') }}" class="comment-form space-y-4">
                                    @csrf
                                    <input type="hidden" name="api_recipe_id" value="{{ $recipe['id'] }}">

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sua Avaliação *</label>
                                        <div class="flex items-center space-x-2 text-3xl">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label style="cursor:pointer" class="transition-transform hover:scale-125">
                                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden">
                                                    <span class="text-yellow-400">☆</span>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Comentário (opcional)</label>
                                        <textarea name="content" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none" placeholder="Compartilhe sua experiência com esta receita...">{{ old('content') }}</textarea>
                                    </div>

                                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-200 hover:from-indigo-700 hover:to-purple-700">
                                        Enviar Avaliação
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="border-t border-gray-200 pt-6 text-center">
                                <p class="text-gray-600">Faça <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">login</a> para comentar ou avaliar.</p>
                            </div>
                        @endauth
                    </div>

                    <script>
                        (function(){
                            function initStarsInForm(form){
                                const radios = Array.from(form.querySelectorAll('input[name="rating"]'));
                                if(!radios.length) return;

                                const update = (val) => {
                                    radios.forEach(r => {
                                        const lab = r.closest('label');
                                        const span = lab ? lab.querySelector('span') : r.nextElementSibling;
                                        if(!span) return;
                                        span.textContent = (Number(r.value) <= val) ? '★' : '☆';
                                    });
                                };

                                radios.forEach(r => {
                                    const lab = r.closest('label');
                                    if(lab){
                                        lab.addEventListener('click', (e) => {
                                            e.preventDefault();
                                            r.checked = true;
                                            r.dispatchEvent(new Event('change', {bubbles:true}));
                                        });
                                    }
                                    r.addEventListener('change', (e) => {
                                        update(Number(e.target.value));
                                    });
                                });

                                const checked = radios.find(r => r.checked);
                                if(checked){
                                    update(Number(checked.value));
                                }
                            }

                            document.querySelectorAll('.comment-form, .comment-edit-form').forEach(f => initStarsInForm(f));
                        })();
                    </script>
                </div>

                {{-- Sidebar com recomendações (1 coluna) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center mb-6">
                            <span class="text-2xl mr-2">📌</span>
                            <h3 class="text-lg font-bold text-gray-900">Receitas Recomendadas</h3>
                        </div>
                        
                        @if ($recommended->isEmpty())
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-600 text-sm">Nenhuma receita recomendada.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($recommended as $rec)
                                    <a href="{{ route('recipes.show', $rec) }}" class="block group">
                                        <div class="border border-gray-200 rounded-xl overflow-hidden hover:border-indigo-400 transition-all duration-200 hover:shadow-md">
                                            {{-- Imagem com overlay --}}
                                            <div class="relative h-24 bg-gradient-to-br from-indigo-400 to-purple-500 overflow-hidden">
                                                @if ($rec->image)
                                                    <img src="{{ asset('storage/' . $rec->image) }}" 
                                                         alt="{{ $rec->title }}" 
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-white text-xs">Sem imagem</div>
                                                @endif
                                            </div>

                                            {{-- Info --}}
                                            <div class="p-3 bg-gradient-to-br from-white to-gray-50">
                                                <p class="font-semibold text-sm text-gray-900 truncate group-hover:text-indigo-600 transition-colors">
                                                    {{ Str::limit($rec->title, 25) }}
                                                </p>
                                                
                                                <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ Str::limit($rec->description, 50) }}</p>
                                                
                                                <div class="mt-2 flex flex-wrap gap-1">
                                                    @if ($rec->prep_time)
                                                        <span class="text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full">⏱️ {{ $rec->prep_time }}m</span>
                                                    @endif
                                                    
                                                    @if ($rec->difficulty)
                                                        <span class="text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full">{{ substr($rec->difficulty, 0, 3) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
