<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PokemonFactory extends Factory
{
    private static array $suffixes = [
        'saur','char','zard','tle','chu','bat','puff','duck',
        'dra','volt','wing','fang','claw','flame','aqua',
        'blob','stone','bell','wak','bro',
    ];

    public function definition(): array
    {
        return [
            'name'            => $this->faker->unique()->firstName()
                                  . $this->faker->randomElement(self::$suffixes),
            'pokedex_number'  => 0, // sera écrasé par séquence dans le seeder
            'description'     => $this->faker->paragraph(2),
            'hp'              => $this->faker->numberBetween(20, 255),
            'attack'          => $this->faker->numberBetween(20, 255),
            'defense'         => $this->faker->numberBetween(20, 255),
            'special_attack'  => $this->faker->numberBetween(20, 255),
            'special_defense' => $this->faker->numberBetween(20, 255),
            'speed'           => $this->faker->numberBetween(20, 255),
            'height'          => $this->faker->randomFloat(2, 0.1, 15.0),
            'weight'          => $this->faker->randomFloat(2, 0.5, 999.9),
            'generation'      => 1,
            'sprite_url'      => '',
        ];
    }
}
