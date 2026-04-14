<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TypeFactory extends Factory
{
    public function definition(): array
    {
        static $colors = [
            '#A8A878','#C03028','#A8B820','#6890F0','#F08030',
            '#98D8D8','#7038F8','#705898','#B8A038','#78C850',
            '#F8D030','#E8A030','#F85888','#98A8B8','#A890F0',
            '#705848','#B8B8D0','#4DC1A1',
        ];
        static $index = 0;

        return [
            'name'  => $this->faker->unique()->word(),
            'color' => $colors[$index++ % count($colors)],
        ];
    }
}
