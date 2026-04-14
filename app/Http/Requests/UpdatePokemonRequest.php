<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePokemonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $pokemonId = $this->route('pokemon')->id;

        return [
            'name'            => ['required', 'string', 'max:100',
                                  Rule::unique('pokemons', 'name')->ignore($pokemonId)],
            'pokedex_number'  => ['required', 'integer', 'min:1',
                                  Rule::unique('pokemons', 'pokedex_number')->ignore($pokemonId)],
            'description'     => ['required', 'string'],
            'hp'              => ['required', 'integer', 'min:1', 'max:255'],
            'attack'          => ['required', 'integer', 'min:1', 'max:255'],
            'defense'         => ['required', 'integer', 'min:1', 'max:255'],
            'special_attack'  => ['required', 'integer', 'min:1', 'max:255'],
            'special_defense' => ['required', 'integer', 'min:1', 'max:255'],
            'speed'           => ['required', 'integer', 'min:1', 'max:255'],
            'height'          => ['required', 'numeric', 'min:0.1'],
            'weight'          => ['required', 'numeric', 'min:0.1'],
            'generation'      => ['required', 'integer', 'min:1', 'max:9'],
            'sprite_url'      => ['required', 'url'],
            'types'           => ['required', 'array', 'min:1', 'max:2'],
            'types.*'         => ['exists:types,id'],
        ];
    }
}
