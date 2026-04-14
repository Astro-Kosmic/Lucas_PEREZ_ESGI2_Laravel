<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemons';

    protected $fillable = [
        'name', 'pokedex_number', 'description',
        'hp', 'attack', 'defense',
        'special_attack', 'special_defense', 'speed',
        'height', 'weight', 'generation', 'sprite_url',
    ];

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'pokemon_type');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'pokemon_team')
            ->withPivot('position', 'nickname');
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function getTotalStatsAttribute(): int
    {
        return $this->hp + $this->attack + $this->defense
             + $this->special_attack + $this->special_defense + $this->speed;
    }
}
