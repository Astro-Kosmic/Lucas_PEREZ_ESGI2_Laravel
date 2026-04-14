<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePokemonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:100', 'unique:pokemons,name'],
            'pokedex_number'  => ['required', 'integer', 'min:1', 'unique:pokemons,pokedex_number'],
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
