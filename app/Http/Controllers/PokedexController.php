<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Type;
use Illuminate\Http\Request;

class PokedexController extends Controller
{
    public function index(Request $request)
    {
        $query = Pokemon::with('types')->orderBy('pokedex_number');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->whereHas('types', fn($q) =>
                $q->where('types.id', $request->type)
            );
        }

        $pokemons = $query->paginate(20)->appends($request->query());

        $favoriteIds = auth()->user()
            ->favoritePokemon()
            ->pluck('pokemons.id')
            ->toArray();

        return view('pokedex.index', [
            'pokemons'    => $pokemons,
            'types'       => Type::orderBy('name')->get(),
            'favoriteIds' => $favoriteIds,
        ]);
    }

    public function show(Pokemon $pokemon)
    {
        $pokemon->load('types');

        $isFavorite = auth()->user()
            ->favoritePokemon()
            ->where('pokemons.id', $pokemon->id)
            ->exists();

        $userTeams = auth()->user()->teams()->get();

        return view('pokedex.show', compact('pokemon', 'isFavorite', 'userTeams'));
    }
}
