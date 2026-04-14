<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Team;
use App\Models\Type;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'stats' => [
                'pokemons' => Pokemon::count(),
                'users'    => User::count(),
                'teams'    => Team::count(),
                'types'    => Type::count(),
            ],
            'featuredPokemons' => Pokemon::inRandomOrder()->limit(3)->get(),
        ]);
    }
}
