<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamOwnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_edit_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user)->get("/teams/{$team->id}/edit")->assertStatus(200);
    }

    public function test_non_owner_cannot_edit_team(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $team  = Team::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($other)->get("/teams/{$team->id}/edit")->assertStatus(403);
    }

    public function test_non_owner_cannot_delete_team(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $team  = Team::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($other)->delete("/teams/{$team->id}")->assertStatus(403);
    }

    public function test_owner_can_delete_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user)->delete("/teams/{$team->id}")
             ->assertRedirect(route('teams.index'));
        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
