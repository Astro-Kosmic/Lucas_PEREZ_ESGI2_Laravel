<x-app-layout>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Supervision des Équipes</h1>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipe</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Propriétaire</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pokémon</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($teams as $team)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $team->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $team->user->name }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-1 flex-wrap">
                                @foreach($team->pokemons as $pokemon)
                                    <x-pokemon-sprite :pokemon="$pokemon" size="w-8 h-8" />
                                @endforeach
                                @if($team->pokemons->count() === 0)
                                    <span class="text-gray-400 text-xs italic">Vide</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.teams.show', $team) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm">Voir</a>
                                <form method="POST" action="{{ route('admin.teams.destroy', $team) }}"
                                      onsubmit="return confirm('Supprimer l\'équipe {{ $team->name }} ?')">
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
        {{ $teams->links() }}
    </div>
</x-app-layout>
