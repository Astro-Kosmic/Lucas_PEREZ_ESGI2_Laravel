<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Pokemon;
use App\Models\Team;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------
        // 1. Types (18)
        // -------------------------------------------------------
        $types = Type::factory()->count(18)->create();

        // -------------------------------------------------------
        // 2. Pokémon (50) — pokedex_number garanti unique via séquence
        // -------------------------------------------------------
        $pokemons = collect();
        for ($i = 1; $i <= 50; $i++) {
            $pokemon = Pokemon::factory()->create(['pokedex_number' => $i]);
            $pokemon->update([
                'sprite_url' => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$i}.png",
            ]);
            $pokemons->push($pokemon);
        }

        // -------------------------------------------------------
        // 3. Associations Pokémon ↔ Types (1 ou 2 types, sans doublon)
        // -------------------------------------------------------
        $pokemons->each(function ($pokemon) use ($types) {
            $nbTypes = fake()->randomElement([1, 1, 1, 2, 2]);
            $selectedIds = $types->random($nbTypes)->pluck('id')->unique()->toArray();
            $pokemon->types()->sync($selectedIds);
        });

        // -------------------------------------------------------
        // 4. Users de test (comptes fixes pour le prof)
        // -------------------------------------------------------
        $admin = User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@pokedex.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        $user = User::factory()->create([
            'name'     => 'Dresseur',
            'email'    => 'user@pokedex.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        $extraUsers = User::factory()->count(5)->create();

        // -------------------------------------------------------
        // 5. Équipes
        // -------------------------------------------------------
        $this->createTeamWithPokemons($user, $pokemons, 'Mon équipe principale');
        $this->createTeamWithPokemons($user, $pokemons, 'Équipe secondaire');

        $extraUsers->each(function ($u) use ($pokemons) {
            $this->createTeamWithPokemons($u, $pokemons);
        });

        // -------------------------------------------------------
        // 6. Favoris (user de test : 8 pokémon favoris)
        // -------------------------------------------------------
        $favoritedIds = $pokemons->random(8)->pluck('id')->toArray();
        foreach ($favoritedIds as $pokemonId) {
            Favorite::firstOrCreate([
                'user_id'    => $user->id,
                'pokemon_id' => $pokemonId,
            ]);
        }

        $extraUsers->each(function ($u) use ($pokemons) {
            $count = fake()->numberBetween(2, 10);
            $pokemons->random($count)->pluck('id')->each(function ($pokemonId) use ($u) {
                Favorite::firstOrCreate([
                    'user_id'    => $u->id,
                    'pokemon_id' => $pokemonId,
                ]);
            });
        });
    }

    private function createTeamWithPokemons($user, $pokemons, ?string $name = null): void
    {
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'name'    => $name ?? fake()->randomElement(['Équipe','Team']) . ' ' . fake()->word(),
        ]);

        $nbPokemons = fake()->numberBetween(3, 6);
        $selectedPokemons = $pokemons->random($nbPokemons);
        $usedIds = [];

        foreach ($selectedPokemons as $position => $pokemon) {
            if (in_array($pokemon->id, $usedIds)) {
                continue;
            }
            $usedIds[] = $pokemon->id;

            $team->pokemons()->attach($pokemon->id, [
                'position' => $position + 1,
                'nickname' => fake()->optional(0.5)->firstName(),
            ]);
        }
    }
}
