<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Pokemon;
use App\Models\Team;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'pokemons'  => Pokemon::count(),
                'users'     => User::count(),
                'teams'     => Team::count(),
                'favorites' => Favorite::count(),
            ],
        ]);
    }
}
