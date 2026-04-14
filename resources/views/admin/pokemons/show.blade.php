<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('admin.pokemons.index') }}" class="hover:text-red-600">Pokémon</a>
            <span class="mx-2">›</span>
            <span class="text-gray-800 font-medium">{{ $pokemon->name }}</span>
        </nav>
        <div class="flex gap-3">
            <a href="{{ route('admin.pokemons.edit', $pokemon) }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                Modifier
            </a>
            <form method="POST" action="{{ route('admin.pokemons.destroy', $pokemon) }}"
                  onsubmit="return confirm('Supprimer {{ $pokemon->name }} définitivement ?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="flex flex-col items-center md:w-1/3">
                <x-pokemon-sprite :pokemon="$pokemon" size="w-48 h-48" />
                <p class="text-gray-400 text-sm mt-2">#{{ str_pad($pokemon->pokedex_number, 3, '0', STR_PAD_LEFT) }}</p>
                <h1 class="text-3xl font-bold text-gray-800 mt-1">{{ $pokemon->name }}</h1>
                <div class="flex gap-2 mt-3 flex-wrap justify-center">
                    @foreach($pokemon->types as $type)
                        <span class="px-3 py-1 rounded-full text-white text-sm font-medium"
                              style="background-color: {{ $type->color }}">
                            {{ $type->name }}
                        </span>
                    @endforeach
                </div>
                <div class="mt-4 text-sm text-gray-600 space-y-1 text-center">
                    <p>Taille : <strong>{{ $pokemon->height }} m</strong></p>
                    <p>Poids : <strong>{{ $pokemon->weight }} kg</strong></p>
                    <p>Génération : <strong>{{ $pokemon->generation }}</strong></p>
                </div>
            </div>

            <div class="flex-1">
                <p class="text-gray-700 mb-6 leading-relaxed">{{ $pokemon->description }}</p>

                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques de combat</h2>
                @php
                    $stats = [
                        'HP'       => $pokemon->hp,
                        'Attaque'  => $pokemon->attack,
                        'Défense'  => $pokemon->defense,
                        'Sp. Atk'  => $pokemon->special_attack,
                        'Sp. Déf'  => $pokemon->special_defense,
                        'Vitesse'  => $pokemon->speed,
                    ];
                @endphp
                <div class="space-y-3">
                    @foreach($stats as $label => $value)
                        <div class="flex items-center gap-3">
                            <span class="w-20 text-sm text-gray-600">{{ $label }}</span>
                            <span class="w-8 text-right text-sm font-bold">{{ $value }}</span>
                            <div class="flex-1 bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full {{ $value > 100 ? 'bg-green-500' : ($value > 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                     style="width: {{ min(100, ($value / 255) * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="mt-4 text-sm text-gray-500">Total : <strong class="text-gray-800">{{ $pokemon->total_stats }}</strong></p>
            </div>
        </div>
    </div>
</x-app-layout>
