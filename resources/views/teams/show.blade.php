<x-app-layout>
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $team->name }}</h1>
            @if($team->description)
                <p class="text-gray-500 mt-1">{{ $team->description }}</p>
            @endif
        </div>
        <div class="flex gap-3">
            <a href="{{ route('teams.edit', $team) }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                Éditer
            </a>
            <form method="POST" action="{{ route('teams.destroy', $team) }}"
                  onsubmit="return confirm('Supprimer cette équipe ?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- 6 slots --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @for ($i = 1; $i <= 6; $i++)
            @php $pokemonSlot = $team->pokemons->firstWhere('pivot.position', $i); @endphp

            @if ($pokemonSlot)
                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center text-center">
                    <p class="text-xs text-gray-400 mb-1">Slot {{ $i }}</p>
                    <x-pokemon-sprite :pokemon="$pokemonSlot" size="w-16 h-16" />
                    <p class="font-bold text-gray-800 mt-2">
                        {{ $pokemonSlot->pivot->nickname ?? $pokemonSlot->name }}
                    </p>
                    @if($pokemonSlot->pivot->nickname)
                        <p class="text-xs text-gray-400">({{ $pokemonSlot->name }})</p>
                    @endif
                    <div class="flex gap-1 mt-1 flex-wrap justify-center">
                        @foreach($pokemonSlot->types as $type)
                            <span class="px-2 py-0.5 rounded-full text-white text-xs"
                                  style="background-color: {{ $type->color }}">
                                {{ $type->name }}
                            </span>
                        @endforeach
                    </div>
                    <form method="POST"
                          action="{{ route('teams.removePokemon', [$team, $pokemonSlot]) }}"
                          class="mt-3"
                          onsubmit="return confirm('Retirer ce Pokémon ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">
                            Retirer
                        </button>
                    </form>
                </div>
            @else
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 flex flex-col items-center justify-center text-center min-h-36">
                    <p class="text-gray-400 text-sm mb-2">Slot {{ $i }} — Vide</p>
                    <a href="{{ route('pokedex.index') }}"
                       class="text-red-600 hover:text-red-800 text-xs font-medium">
                        Ajouter un Pokémon
                    </a>
                </div>
            @endif
        @endfor
    </div>

    <div class="mt-6">
        <a href="{{ route('teams.index') }}" class="text-red-600 hover:text-red-800 font-medium">
            ← Retour aux équipes
        </a>
    </div>
</x-app-layout>
