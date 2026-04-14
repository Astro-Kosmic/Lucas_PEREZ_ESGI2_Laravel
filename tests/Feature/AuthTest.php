<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_accessible(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_register_page_accessible(): void
    {
        $this->get('/register')->assertStatus(200);
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
             ->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    public function test_guest_cannot_access_pokedex(): void
    {
        $this->get('/pokedex')->assertRedirect('/login');
    }
}
