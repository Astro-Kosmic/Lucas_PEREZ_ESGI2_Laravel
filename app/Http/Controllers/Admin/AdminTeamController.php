<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;

class AdminTeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['user', 'pokemons'])->paginate(20);
        return view('admin.teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        $team->load(['user', 'pokemons.types']);
        return view('admin.teams.show', compact('team'));
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Équipe supprimée.');
    }
}
