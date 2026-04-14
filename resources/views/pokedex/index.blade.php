<x-app-layout>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Pokédex</h1>

    {{-- Recherche --}}
    <form method="GET" action="{{ route('pokedex.index') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher un Pokémon..."
               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
        <input type="hidden" name="type" value="{{ request('type') }}">
        <button type="submit"
                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
            Rechercher
        </button>
    </form>

    {{-- Filtres par type --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('pokedex.index', ['search' => request('search')]) }}"
           class="px-3 py-1 rounded-full text-sm font-medium {{ !request('type') ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Tous
        </a>
        @foreach($types as $type)
            <a href="{{ route('pokedex.index', ['type' => $type->id, 'search' => request('search')]) }}"
               style="background-color: {{ $type->color }}"
               class="px-3 py-1 rounded-full text-white text-sm font-medium opacity-{{ request('type') == $type->id ? '100' : '70' }} hover:opacity-100 transition">
                {{ $type->name }}
            </a>
        @endforeach
    </div>

    {{-- Grille --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($pokemons as $pokemon)
            <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center text-center hover:shadow-md transition">
                <x-pokemon-sprite :pokemon="$pokemon" size="w-20 h-20" />
                <p class="text-gray-400 text-xs mt-2">#{{ str_pad($pokemon->pokedex_number, 3, '0', STR_PAD_LEFT) }}</p>
                <p class="font-bold text-gray-800">{{ $pokemon->name }}</p>
                <div class="flex gap-1 mt-1 flex-wrap justify-center">
                    @foreach($pokemon->types as $type)
                        <span class="px-2 py-0.5 rounded-full text-white text-xs"
                              style="background-color: {{ $type->color }}">
                            {{ $type->name }}
                        </span>
                    @endforeach
                </div>
                <div class="flex items-center gap-2 mt-3">
                    <form method="POST" action="{{ route('favorites.toggle', $pokemon) }}">
                        @csrf
                        <button type="submit" class="text-xl hover:scale-110 transition">
                            {{ in_array($pokemon->id, $favoriteIds) ? '❤️' : '🤍' }}
                        </button>
                    </form>
                    <a href="{{ route('pokedex.show', $pokemon) }}"
                       class="text-red-600 hover:text-red-800 text-sm font-medium">
                        Voir →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-12 text-gray-500">
                Aucun Pokémon trouvé pour cette recherche.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $pokemons->appends(request()->query())->links() }}
    </div>
</x-app-layout>
