<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchGame extends Model
{
    /** @use HasFactory<\Database\Factories\MatchFactory> */
    use HasFactory;

    protected $guarded = [];

   
public function players() {
    return $this->belongsToMany(User::class, 'matchh_user')
                ->withPivot('gold_gained', 'gems_gained', 'rank', 'wins', 'loss', 'experience_gained');
}
}
