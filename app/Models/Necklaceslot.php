<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Necklaceslot extends Model // TODO: wrong name for the model, it should be NecklaceSlot
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\NecklaceSlotFactory> */
    use HasFactory;

    // TODO: missing fillable

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_necklace_slot')
            ->withTimestamps();
    }
}
