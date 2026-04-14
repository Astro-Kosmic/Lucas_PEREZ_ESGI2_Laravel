<x-app-layout>
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $team->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">Propriétaire : {{ $team->user->name }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.teams.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                ← Retour
            </a>
            <form method="POST" action="{{ route('admin.teams.destroy', $team) }}"
                  onsubmit="return confirm('Supprimer cette équipe définitivement ?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                    Supprimer l'équipe
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($team->pokemons as $pokemon)
            <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center text-center">
                <p class="text-xs text-gray-400 mb-1">Slot {{ $pokemon->pivot->position }}</p>
                <x-pokemon-sprite :pokemon="$pokemon" size="w-16 h-16" />
                <p class="font-bold text-gray-800 mt-2">
                    {{ $pokemon->pivot->nickname ?? $pokemon->name }}
                </p>
                @if($pokemon->pivot->nickname)
                    <p class="text-xs text-gray-400">({{ $pokemon->name }})</p>
                @endif
                <div class="flex gap-1 mt-1 flex-wrap justify-center">
                    @foreach($pokemon->types as $type)
                        <span class="px-2 py-0.5 rounded-full text-white text-xs"
                              style="background-color: {{ $type->color }}">
                            {{ $type->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endforeach

        @if($team->pokemons->count() === 0)
            <div class="col-span-3 text-center py-8 text-gray-400">
                Cette équipe est vide.
            </div>
        @endif
    </div>
</x-app-layout>
