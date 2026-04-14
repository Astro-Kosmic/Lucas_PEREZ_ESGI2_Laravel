<x-app-layout>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Modifier le rôle — {{ $user->name }}</h1>

    <div class="bg-white rounded-xl shadow p-8 max-w-sm">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rôle *</label>
                <select name="role" id="role"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('role') border-red-500 @enderror">
                    <option value="user" @selected(old('role', $user->role) === 'user')>Utilisateur</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-medium">
                    Sauvegarder
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
