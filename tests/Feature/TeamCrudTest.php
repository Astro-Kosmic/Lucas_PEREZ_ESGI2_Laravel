<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_team(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/teams', [
            'name'        => 'Mon équipe test',
            'description' => 'Description test',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('teams', [
            'name'    => 'Mon équipe test',
            'user_id' => $user->id,
        ]);
    }

    public function test_team_name_is_required(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/teams', ['name' => ''])
             ->assertSessionHasErrors('name');
    }

    public function test_user_can_update_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user)->put("/teams/{$team->id}", [
            'name'        => 'Nom modifié',
            'description' => null,
        ])->assertRedirect();
        $this->assertDatabaseHas('teams', ['id' => $team->id, 'name' => 'Nom modifié']);
    }
}
