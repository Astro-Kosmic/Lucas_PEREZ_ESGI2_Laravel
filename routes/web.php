<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPokemonController;
use App\Http\Controllers\Admin\AdminTeamController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PokedexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Alias dashboard → home (requis par Breeze après login/register)
Route::get('/dashboard', [HomeController::class, 'index'])->middleware('auth')->name('dashboard');

// Routes authentifiées
Route::middleware('auth')->group(function () {

    // Pokédex (lecture seule)
    Route::get('/pokedex', [PokedexController::class, 'index'])->name('pokedex.index');
    Route::get('/pokedex/{pokemon}', [PokedexController::class, 'show'])->name('pokedex.show');

    // Favoris
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{pokemon}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Profil utilisateur (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Équipes (CRUD Resource complet)
    Route::resource('teams', TeamController::class);

    // Ajout/retrait de Pokémon dans une équipe (hors resource)
    Route::post('/teams/{team}/pokemons', [TeamController::class, 'addPokemon'])
         ->name('teams.addPokemon');
    Route::delete('/teams/{team}/pokemons/{pokemon}', [TeamController::class, 'removePokemon'])
         ->name('teams.removePokemon');
});

// Administration — double middleware auth + admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('pokemons', AdminPokemonController::class);
        Route::resource('users', AdminUserController::class)->except(['create', 'store']);
        Route::get('teams', [AdminTeamController::class, 'index'])->name('teams.index');
        Route::get('teams/{team}', [AdminTeamController::class, 'show'])->name('teams.show');
        Route::delete('teams/{team}', [AdminTeamController::class, 'destroy'])->name('teams.destroy');
    });

// Routes Breeze (auth) — incluses automatiquement
require __DIR__.'/auth.php';
