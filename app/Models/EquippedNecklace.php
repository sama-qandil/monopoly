<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquippedNecklace extends Model
{
    /** @use HasFactory<\Database\Factories\EquippedNecklaceFactory> */
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
