<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePokemonRequest;
use App\Http\Requests\UpdatePokemonRequest;
use App\Models\Pokemon;
use App\Models\Type;

class AdminPokemonController extends Controller
{
    public function index()
    {
        $pokemons = Pokemon::with('types')->orderBy('pokedex_number')->paginate(20);
        return view('admin.pokemons.index', compact('pokemons'));
    }

    public function create()
    {
        $types = Type::orderBy('name')->get();
        return view('admin.pokemons.create', compact('types'));
    }

    public function store(StorePokemonRequest $request)
    {
        $pokemon = Pokemon::create($request->safe()->except('types'));
        $pokemon->types()->sync($request->validated()['types']);
        return redirect()->route('admin.pokemons.index')->with('success', 'Pokémon créé.');
    }

    public function show(Pokemon $pokemon)
    {
        $pokemon->load('types');
        return view('admin.pokemons.show', compact('pokemon'));
    }

    public function edit(Pokemon $pokemon)
    {
        $pokemon->load('types');
        $types = Type::orderBy('name')->get();
        $selectedTypeIds = $pokemon->types->pluck('id')->toArray();
        return view('admin.pokemons.edit', compact('pokemon', 'types', 'selectedTypeIds'));
    }

    public function update(UpdatePokemonRequest $request, Pokemon $pokemon)
    {
        $pokemon->update($request->safe()->except('types'));
        $pokemon->types()->sync($request->validated()['types']);
        return redirect()->route('admin.pokemons.index')->with('success', 'Pokémon mis à jour.');
    }

    public function destroy(Pokemon $pokemon)
    {
        $pokemon->delete();
        return redirect()->route('admin.pokemons.index')->with('success', 'Pokémon supprimé.');
    }
}
