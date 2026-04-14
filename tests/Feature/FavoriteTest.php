<?php

namespace Tests\Feature;

use App\Models\Pokemon;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    private function createPokemon(): Pokemon
    {
        $type = Type::factory()->create();
        $pokemon = Pokemon::factory()->create(['pokedex_number' => 1]);
        $pokemon->types()->attach($type->id);
        return $pokemon;
    }

    public function test_user_can_add_favorite(): void
    {
        $user    = User::factory()->create();
        $pokemon = $this->createPokemon();
        $this->actingAs($user)->post("/favorites/{$pokemon->id}")
             ->assertRedirect();
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id, 'pokemon_id' => $pokemon->id,
        ]);
    }

    public function test_user_can_remove_favorite(): void
    {
        $user    = User::factory()->create();
        $pokemon = $this->createPokemon();
        $user->favoritePokemon()->attach($pokemon->id);
        $this->actingAs($user)->post("/favorites/{$pokemon->id}")->assertRedirect();
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id, 'pokemon_id' => $pokemon->id,
        ]);
    }

    public function test_guest_cannot_access_favorites(): void
    {
        $this->get('/favorites')->assertRedirect('/login');
    }
}
