<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">⚔️ Mes Équipes</h1>
        <a href="{{ route('teams.create') }}"
           class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-medium">
            + Créer une équipe
        </a>
    </div>

    <div class="space-y-4">
        @forelse($teams as $team)
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $team->name }}</h2>
                        @if($team->description)
                            <p class="text-gray-500 text-sm mt-1">{{ $team->description }}</p>
                        @endif
                        <div class="flex gap-2 mt-3 flex-wrap">
                            @foreach($team->pokemons as $pokemon)
                                <x-pokemon-sprite :pokemon="$pokemon" size="w-12 h-12" />
                            @endforeach
                            @if($team->pokemons->count() === 0)
                                <p class="text-gray-400 text-sm italic">Équipe vide</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <a href="{{ route('teams.show', $team) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir</a>
                        <a href="{{ route('teams.edit', $team) }}"
                           class="text-gray-600 hover:text-gray-800 text-sm font-medium">Éditer</a>
                        <form method="POST" action="{{ route('teams.destroy', $team) }}"
                              onsubmit="return confirm('Supprimer cette équipe ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 text-gray-500">
                <p class="text-5xl mb-4">⚔️</p>
                <p class="text-lg">Aucune équipe. Créez votre première équipe !</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
