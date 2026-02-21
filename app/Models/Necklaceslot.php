<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Necklaceslot extends Model
{
    /** @use HasFactory<\Database\Factories\NecklaceSlotFactory> */
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_necklace_slot')
                    ->withTimestamps();
    }
}
