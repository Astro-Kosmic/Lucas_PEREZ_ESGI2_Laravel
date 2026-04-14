<x-app-layout>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Créer une équipe</h1>

    <div class="bg-white rounded-xl shadow p-8 max-w-lg">
        <form method="POST" action="{{ route('teams.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'équipe *</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name') }}"
                       maxlength="50" required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3" maxlength="255"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-medium">
                    Créer
                </button>
                <a href="{{ route('teams.index') }}"
                   class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
