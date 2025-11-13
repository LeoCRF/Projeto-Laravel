<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Receitas Sustentáveis') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-gray-100 flex flex-col min-h-screen">

    <!-- Navbar (modern, overlay) -->
    <nav id="main-nav" class="fixed inset-x-0 top-0 z-50">
        <div id="nav-inner" class="backdrop-blur-sm bg-black/30 border-b border-white/5 transition-colors duration-300">
            <div class="container mx-auto px-6 py-4 flex items-center justify-between">
                <a href="{{ route('recipes.index') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg">
                        <span class="text-white font-black">🍃</span>
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="text-white font-extrabold text-lg">Receitas Sustentáveis</span>
                        <span class="text-xs text-white/60 -mt-1">SmartCook</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('recipes.index') }}" class="text-white/90 hover:text-white transition font-medium">Explorar</a>

                    {{-- Search --}}
                    <form method="GET" action="{{ route('recipes.index') }}" class="hidden lg:flex items-center bg-white/5 border border-white/6 rounded-full px-3 py-1">
                        <input name="q" type="search" placeholder="Buscar receitas..." class="bg-transparent placeholder-white/60 text-white/90 px-3 py-2 outline-none w-64" value="{{ request('q') }}">
                        <button type="submit" class="text-white/90 px-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
                        </button>
                    </form>

                    @auth
                        {{-- User dropdown --}}
                        <div class="relative" x-data="{}">
                            <button id="user-dropdown-button" class="flex items-center gap-3 bg-white/5 px-3 py-1 rounded-full hover:bg-white/8 transition" aria-expanded="false">
                                @if (Auth::user() && Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar" class="w-9 h-9 rounded-full object-cover border border-white/10">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                                <div class="hidden sm:block text-sm text-white/90">{{ Auth::user()->name ?? 'Usuário' }}</div>
                                <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div id="user-dropdown" class="hidden absolute right-0 mt-3 w-56 bg-slate-800/90 border border-white/5 rounded-xl shadow-lg py-2">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-white/90 hover:bg-white/5">Perfil</a>
                                <a href="{{ route('recipes.index') }}?mine=1" class="block px-4 py-2 text-sm text-white/90 hover:bg-white/5">Minhas Receitas</a>
                                <a href="{{ route('profile.edit') }}#settings" class="block px-4 py-2 text-sm text-white/90 hover:bg-white/5">Configurações</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-white/5">Sair</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 border border-white/10 rounded-md text-white/90 hover:bg-white/5 transition">Entrar</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-white text-purple-700 rounded-md font-semibold hover:opacity-95 transition">Registrar</a>
                    @endauth
                </div>

                {{-- Mobile menu trigger --}}
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white/90 focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile menu (hidden by default) --}}
            <div id="mobile-menu" class="hidden md:hidden border-t border-white/5 bg-slate-900/90">
                <div class="px-6 py-4 flex flex-col gap-3">
                    <a href="{{ route('recipes.index') }}" class="text-white/90">Explorar</a>
                    @auth
                        <a href="{{ route('recipes.create') }}" class="text-white/90">Nova Receita</a>
                        <a href="{{ route('profile.edit') }}" class="text-white/90">Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-white/90 text-left">Sair</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white/90">Entrar</a>
                        <a href="{{ route('register') }}" class="text-white/90">Registrar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="flex-grow container mx-auto px-6 py-10 pt-24 text-gray-900">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Rodapé -->
    <footer class="bg-green-700 text-white text-center py-4 mt-auto">
        <p class="text-sm">&copy; {{ date('Y') }} Receitas Sustentáveis. Todos os direitos reservados.</p>
    </footer>

    </footer>

    </script>

    <script>
        // mobile menu toggle & dropdown & scroll effect
        document.addEventListener('DOMContentLoaded', function () {
            var btn = document.getElementById('mobile-menu-button');
            var menu = document.getElementById('mobile-menu');
            var userBtn = document.getElementById('user-dropdown-button');
            var userMenu = document.getElementById('user-dropdown');
            var navInner = document.getElementById('nav-inner');

            if (btn && menu) {
                btn.addEventListener('click', function () {
                    menu.classList.toggle('hidden');
                });
            }

            if (userBtn && userMenu) {
                userBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                });

                // close when clicking outside
                document.addEventListener('click', function (e) {
                    if (! userMenu.classList.contains('hidden')) {
                        userMenu.classList.add('hidden');
                    }
                });
            }

            // scroll effect: transparent over top, solid after scroll
            function onScroll() {
                if (!navInner) return;
                if (window.scrollY > 80) {
                    navInner.classList.remove('bg-black/10');
                    navInner.classList.add('bg-white/95', 'shadow-lg');
                    // change text color for links
                    document.querySelectorAll('#nav-inner a, #nav-inner button').forEach(function (el) {
                        el.classList.remove('text-white/90');
                        el.classList.add('text-gray-800');
                    });
                } else {
                    navInner.classList.remove('bg-white/95', 'shadow-lg');
                    navInner.classList.add('bg-black/30');
                    document.querySelectorAll('#nav-inner a, #nav-inner button').forEach(function (el) {
                        el.classList.remove('text-gray-800');
                        el.classList.add('text-white/90');
                    });
                }
            }

            onScroll();
            window.addEventListener('scroll', onScroll);
        });
    </script>

    </body>
</html>
