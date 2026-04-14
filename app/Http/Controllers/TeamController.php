<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Pokemon;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = auth()->user()->teams()->with('pokemons')->get();
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(StoreTeamRequest $request)
    {
        $team = auth()->user()->teams()->create($request->validated());
        return redirect()->route('teams.show', $team)->with('success', 'Équipe créée !');
    }

    public function show(Team $team)
    {
        $this->checkOwnership($team);
        $team->load('pokemons.types');
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $this->checkOwnership($team);
        return view('teams.edit', compact('team'));
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        $this->checkOwnership($team);
        $team->update($request->validated());
        return redirect()->route('teams.show', $team)->with('success', 'Équipe mise à jour.');
    }

    public function destroy(Team $team)
    {
        $this->checkOwnership($team);
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Équipe supprimée.');
    }

    public function addPokemon(Request $request, Team $team)
    {
        $this->checkOwnership($team);
        $request->validate([
            'pokemon_id' => ['required', 'exists:pokemons,id'],
            'position'   => ['required', 'integer', 'min:1', 'max:6'],
            'nickname'   => ['nullable', 'string', 'max:50'],
        ]);
        if ($team->pokemons()->count() >= 6) {
            return back()->with('error', 'Équipe complète (max 6 Pokémon).');
        }
        if ($team->pokemons()->where('pokemons.id', $request->pokemon_id)->exists()) {
            return back()->with('error', 'Ce Pokémon est déjà dans l\'équipe.');
        }
        $team->pokemons()->attach($request->pokemon_id, [
            'position' => $request->position,
            'nickname' => $request->nickname,
        ]);
        return back()->with('success', 'Pokémon ajouté à l\'équipe !');
    }

    public function removePokemon(Team $team, Pokemon $pokemon)
    {
        $this->checkOwnership($team);
        $team->pokemons()->detach($pokemon->id);
        return back()->with('success', 'Pokémon retiré de l\'équipe.');
    }

    private function checkOwnership(Team $team): void
    {
        if ($team->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas le propriétaire de cette équipe.');
        }
    }
}
