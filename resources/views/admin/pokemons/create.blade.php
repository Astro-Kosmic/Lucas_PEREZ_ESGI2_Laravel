<x-app-layout>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Ajouter un Pokémon</h1>

    <div class="bg-white rounded-xl shadow p-8 max-w-2xl">
        <form method="POST" action="{{ route('admin.pokemons.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                    <input type="text" name="name" value="{{ old('name') }}" maxlength="100" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('name') border-red-500 @enderror">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro Pokédex *</label>
                    <input type="number" name="pokedex_number" value="{{ old('pokedex_number') }}" min="1" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('pokedex_number') border-red-500 @enderror">
                    @error('pokedex_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                <textarea name="description" rows="3" required
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-3 gap-4">
                @foreach(['hp' => 'HP', 'attack' => 'Attaque', 'defense' => 'Défense', 'special_attack' => 'Sp. Atk', 'special_defense' => 'Sp. Déf', 'speed' => 'Vitesse'] as $field => $label)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }} *</label>
                        <input type="number" name="{{ $field }}" value="{{ old($field) }}" min="1" max="255" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error($field) border-red-500 @enderror">
                        @error($field)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Taille (m) *</label>
                    <input type="number" name="height" value="{{ old('height') }}" step="0.01" min="0.1" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('height') border-red-500 @enderror">
                    @error('height')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Poids (kg) *</label>
                    <input type="number" name="weight" value="{{ old('weight') }}" step="0.01" min="0.1" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('weight') border-red-500 @enderror">
                    @error('weight')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Génération *</label>
                    <input type="number" name="generation" value="{{ old('generation', 1) }}" min="1" max="9" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('generation') border-red-500 @enderror">
                    @error('generation')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL du sprite *</label>
                <input type="url" name="sprite_url" value="{{ old('sprite_url') }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('sprite_url') border-red-500 @enderror">
                @error('sprite_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Types * (max 2, Ctrl+clic)</label>
                <select name="types[]" multiple size="6"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('types') border-red-500 @enderror">
                    @foreach($types as $type)
                        <option value="{{ $type->id }}"
                                @selected(in_array($type->id, old('types', [])))>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('types')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-medium">
                    Créer
                </button>
                <a href="{{ route('admin.pokemons.index') }}"
                   class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
