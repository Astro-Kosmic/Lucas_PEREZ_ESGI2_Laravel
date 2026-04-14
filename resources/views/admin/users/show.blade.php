<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="text-red-600 hover:text-red-800 font-medium">
            ← Retour
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Infos --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Informations</h2>
            <dl class="space-y-2 text-sm">
                <div class="flex gap-2">
                    <dt class="text-gray-500 w-24">Email</dt>
                    <dd class="text-gray-800">{{ $user->email }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="text-gray-500 w-24">Rôle</dt>
                    <dd>
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $user->role }}
                        </span>
                    </dd>
                </div>
                <div class="flex gap-2">
                    <dt class="text-gray-500 w-24">Inscrit le</dt>
                    <dd class="text-gray-800">{{ $user->created_at->format('d/m/Y') }}</dd>
                </div>
            </dl>
            <div class="mt-4">
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="text-sm text-blue-600 hover:text-blue-800 font-medium">Modifier le rôle →</a>
            </div>
        </div>

        {{-- Favoris --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Pokémon favoris ({{ $user->favoritePokemon->count() }})</h2>
            <div class="flex flex-wrap gap-2">
                @forelse($user->favoritePokemon as $pokemon)
                    <div class="flex flex-col items-center text-center">
                        <x-pokemon-sprite :pokemon="$pokemon" size="w-10 h-10" />
                        <p class="text-xs text-gray-600 mt-1">{{ $pokemon->name }}</p>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Aucun favori.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Équipes --}}
    <div class="bg-white rounded-xl shadow p-6 mt-6">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Équipes ({{ $user->teams->count() }})</h2>
        <div class="space-y-3">
            @forelse($user->teams as $team)
                <div class="border border-gray-200 rounded-lg p-3 flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">{{ $team->name }}</p>
                        <div class="flex gap-1 mt-1">
                            @foreach($team->pokemons as $pokemon)
                                <x-pokemon-sprite :pokemon="$pokemon" size="w-8 h-8" />
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('admin.teams.show', $team) }}"
                       class="text-blue-600 hover:text-blue-800 text-sm">Voir →</a>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Aucune équipe.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
