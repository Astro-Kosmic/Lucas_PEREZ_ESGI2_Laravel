<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pokédex') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">

    {{-- Navbar --}}
    <nav class="bg-red-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-white text-xl font-bold tracking-wide">
                        🔴 Pokédex
                    </a>
                    <a href="{{ route('home') }}" class="text-red-200 hover:text-white text-sm font-medium">
                        Accueil
                    </a>
                    @auth
                        <a href="{{ route('pokedex.index') }}" class="text-red-200 hover:text-white text-sm font-medium">
                            Pokédex
                        </a>
                        <a href="{{ route('favorites.index') }}" class="text-red-200 hover:text-white text-sm font-medium">
                            Mes Favoris
                        </a>
                        <a href="{{ route('teams.index') }}" class="text-red-200 hover:text-white text-sm font-medium">
                            Mes Équipes
                        </a>
                        @if(auth()->user()->isAdmin())
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="text-red-200 hover:text-white text-sm font-medium">
                                    Admin ▾
                                </button>
                                <div x-show="open" @click.away="open = false"
                                     class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="{{ route('admin.pokemons.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Gérer Pokémon</a>
                                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Gérer Users</a>
                                    <a href="{{ route('admin.teams.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Voir Équipes</a>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-red-200 hover:text-white text-sm font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-white text-red-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-red-50">Inscription</a>
                    @endguest
                    @auth
                        <span class="text-red-200 text-sm">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-200 hover:text-white text-sm font-medium">
                                Déconnexion
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Messages Flash --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Contenu principal --}}
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-gray-400 text-center py-6 mt-12">
        <p class="text-sm">Pokédex App — Projet Laravel ESGI 2026</p>
    </footer>

</body>
</html>
