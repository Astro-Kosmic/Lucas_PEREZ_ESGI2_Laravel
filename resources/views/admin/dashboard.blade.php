<x-app-layout>
    <h1 class="text-3xl font-bold text-gray-800 mb-8">🛡️ Dashboard Admin</h1>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-3xl font-bold text-red-600">{{ $stats['pokemons'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Pokémon</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-3xl font-bold text-blue-600">{{ $stats['users'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Utilisateurs</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $stats['teams'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Équipes</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['favorites'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Favoris</p>
        </div>
    </div>

    {{-- Liens rapides --}}
    <h2 class="text-xl font-bold text-gray-700 mb-4">Accès rapides</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.pokemons.index') }}"
           class="bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl p-6 flex items-center gap-4 transition">
            <span class="text-3xl">🐾</span>
            <div>
                <p class="font-bold text-gray-800">Gérer les Pokémon</p>
                <p class="text-sm text-gray-500">Créer, modifier, supprimer</p>
            </div>
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl p-6 flex items-center gap-4 transition">
            <span class="text-3xl">👥</span>
            <div>
                <p class="font-bold text-gray-800">Gérer les Utilisateurs</p>
                <p class="text-sm text-gray-500">Rôles et suppressions</p>
            </div>
        </a>
        <a href="{{ route('admin.teams.index') }}"
           class="bg-green-50 hover:bg-green-100 border border-green-200 rounded-xl p-6 flex items-center gap-4 transition">
            <span class="text-3xl">⚔️</span>
            <div>
                <p class="font-bold text-gray-800">Voir les Équipes</p>
                <p class="text-sm text-gray-500">Supervision des équipes</p>
            </div>
        </a>
    </div>
</x-app-layout>
