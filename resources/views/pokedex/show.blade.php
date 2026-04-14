<x-app-layout>
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('pokedex.index') }}" class="hover:text-red-600">Pokédex</a>
        <span class="mx-2">›</span>
        <span class="text-gray-800 font-medium">{{ $pokemon->name }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sprite + infos de base --}}
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
                <div class="mt-4 text-sm text-gray-600 space-y-1">
                    <p>Taille : <strong>{{ $pokemon->height }} m</strong></p>
                    <p>Poids : <strong>{{ $pokemon->weight }} kg</strong></p>
                    <p>Génération : <strong>{{ $pokemon->generation }}</strong></p>
                </div>

                {{-- Bouton favori --}}
                <form method="POST" action="{{ route('favorites.toggle', $pokemon) }}" class="mt-4">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2 px-5 py-2 rounded-lg border-2 border-red-300 hover:bg-red-50 transition font-medium text-red-700">
                        {{ $isFavorite ? '❤️ Retirer des favoris' : '🤍 Ajouter aux favoris' }}
                    </button>
                </form>
            </div>

            {{-- Stats + description --}}
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

                {{-- Ajouter à une équipe --}}
                @if($userTeams->count() > 0)
                    <div class="mt-8 border-t pt-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-3">Ajouter à une équipe</h2>
                        <form method="POST" action="#" id="add-to-team-form" class="space-y-3">
                            @csrf
                            <input type="hidden" name="pokemon_id" value="{{ $pokemon->id }}">
                            <select name="team_id" id="team-select"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                @foreach($userTeams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <div class="flex gap-3">
                                <select name="position"
                                        class="rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}">Position {{ $i }}</option>
                                    @endfor
                                </select>
                                <input type="text" name="nickname" placeholder="Surnom (optionnel)"
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                            <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                Ajouter à l'équipe
                            </button>
                        </form>
                        <script>
                            // Mise à jour dynamique de l'action du formulaire selon l'équipe choisie
                            const teamRoutes = @json($userTeams->mapWithKeys(fn($t) => [$t->id => route('teams.addPokemon', $t)]));
                            const select = document.getElementById('team-select');
                            const form = document.getElementById('add-to-team-form');
                            function updateAction() { form.action = teamRoutes[select.value]; }
                            select.addEventListener('change', updateAction);
                            updateAction();
                        </script>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('pokedex.index') }}" class="text-red-600 hover:text-red-800 font-medium">
            ← Retour au Pokédex
        </a>
    </div>
</x-app-layout>
