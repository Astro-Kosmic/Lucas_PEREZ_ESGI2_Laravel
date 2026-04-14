<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->randomElement(['Équipe','Team','Escouade','Squad'])
                             . ' ' . $this->faker->word(),
            'description' => $this->faker->optional(0.7)->sentence(),
            'user_id'     => User::factory(),
        ];
    }
}
