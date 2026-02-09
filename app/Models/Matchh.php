<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matchh extends Model
{
    /** @use HasFactory<\Database\Factories\MatchhFactory> */
    use HasFactory;


   
public function players() {
    return $this->belongsToMany(User::class, 'user_matches')
                ->withPivot('gold_gained', 'gems_gained', 'rank', 'wins', 'loss', 'experience_gained');
}
}
