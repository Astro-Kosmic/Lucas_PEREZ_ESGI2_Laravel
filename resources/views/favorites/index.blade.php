<x-app-layout>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">❤️ Mes Favoris</h1>

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
                        <button type="submit" class="text-xl hover:scale-110 transition" title="Retirer des favoris">
                            ❤️
                        </button>
                    </form>
                    <a href="{{ route('pokedex.show', $pokemon) }}"
                       class="text-red-600 hover:text-red-800 text-sm font-medium">
                        Voir →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-16 text-gray-500">
                <p class="text-5xl mb-4">🤍</p>
                <p class="text-lg">Aucun favori pour le moment.</p>
                <a href="{{ route('pokedex.index') }}" class="mt-3 inline-block text-red-600 hover:text-red-800 font-medium">
                    Découvrir le Pokédex →
                </a>
            </div>
        @endforelse
    </div>
</x-app-layout>
