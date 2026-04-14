<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;

class FavoriteController extends Controller
{
    public function index()
    {
        $pokemons = auth()->user()
            ->favoritePokemon()
            ->with('types')
            ->orderBy('pokedex_number')
            ->get();

        return view('favorites.index', compact('pokemons'));
    }

    public function toggle(Pokemon $pokemon)
    {
        $user = auth()->user();

        if ($user->favoritePokemon()->where('pokemons.id', $pokemon->id)->exists()) {
            $user->favoritePokemon()->detach($pokemon->id);
            $message = "{$pokemon->name} retiré de vos favoris.";
        } else {
            $user->favoritePokemon()->attach($pokemon->id);
            $message = "{$pokemon->name} ajouté aux favoris !";
        }

        return back()->with('success', $message);
    }
}
