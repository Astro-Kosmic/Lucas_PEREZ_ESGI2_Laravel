<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Pokémon</h1>
        <a href="{{ route('admin.pokemons.create') }}"
           class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-medium">
            + Ajouter un Pokémon
        </a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sprite</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Types</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Stats</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($pokemons as $pokemon)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-500">
                            #{{ str_pad($pokemon->pokedex_number, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-4 py-3">
                            <x-pokemon-sprite :pokemon="$pokemon" size="w-10 h-10" />
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $pokemon->name }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-1 flex-wrap">
                                @foreach($pokemon->types as $type)
                                    <span class="px-2 py-0.5 rounded-full text-white text-xs"
                                          style="background-color: {{ $type->color }}">
                                        {{ $type->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-gray-700">{{ $pokemon->total_stats }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.pokemons.show', $pokemon) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm">Voir</a>
                                <a href="{{ route('admin.pokemons.edit', $pokemon) }}"
                                   class="text-gray-600 hover:text-gray-800 text-sm">Éditer</a>
                                <form method="POST" action="{{ route('admin.pokemons.destroy', $pokemon) }}"
                                      onsubmit="return confirm('Supprimer {{ $pokemon->name }} ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $pokemons->links() }}
    </div>
</x-app-layout>
