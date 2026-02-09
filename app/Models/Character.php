<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    /** @use HasFactory<\Database\Factories\CharacterFactory> */
    use HasFactory;



    public function users() {
    return $this->belongsToMany(User::class, 'character_user', 'character_id', 'user_id')
                ->withPivot('current_level', 'current_experience', 'is_selected');
}
}
