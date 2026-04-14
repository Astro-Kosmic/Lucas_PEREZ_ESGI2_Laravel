<x-app-layout>
    {{-- Hero --}}
    <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-2xl text-white text-center py-16 px-8 mb-10">
        <h1 class="text-4xl font-bold mb-3">🔴 Bienvenue sur le Pokédex</h1>
        <p class="text-red-200 text-lg mb-8">Découvrez, collectionnez et gérez vos Pokémon préférés.</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('pokedex.index') }}" class="bg-white text-red-700 font-semibold px-6 py-3 rounded-lg hover:bg-red-50 transition">
                Voir le Pokédex
            </a>
            @guest
                <a href="{{ route('register') }}" class="border border-white text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                    S'inscrire
                </a>
            @endguest
            @auth
                <a href="{{ route('teams.index') }}" class="border border-white text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                    Mes équipes
                </a>
            @endauth
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-3xl font-bold text-red-600">{{ $stats['pokemons'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Pokémon</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-3xl font-bold text-blue-600">{{ $stats['users'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Dresseurs</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $stats['teams'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Équipes</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['types'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Types</p>
        </div>
    </div>

    {{-- À la une --}}
    <h2 class="text-2xl font-bold text-gray-800 mb-4">✨ À la une</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($featuredPokemons as $pokemon)
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center">
                <x-pokemon-sprite :pokemon="$pokemon" size="w-20 h-20" />
                <p class="text-gray-400 text-xs mt-2">#{{ str_pad($pokemon->pokedex_number, 3, '0', STR_PAD_LEFT) }}</p>
                <p class="text-lg font-bold text-gray-800">{{ $pokemon->name }}</p>
                <div class="flex gap-1 mt-2 flex-wrap justify-center">
                    @foreach($pokemon->types as $type)
                        <span class="px-2 py-1 rounded-full text-white text-xs font-medium"
                              style="background-color: {{ $type->color }}">
                            {{ $type->name }}
                        </span>
                    @endforeach
                </div>
                @auth
                    <a href="{{ route('pokedex.show', $pokemon) }}"
                       class="mt-4 text-red-600 hover:text-red-800 text-sm font-medium">
                        Voir la fiche →
                    </a>
                @endauth
            </div>
        @endforeach
    </div>
</x-app-layout>
