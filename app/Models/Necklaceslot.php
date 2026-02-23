<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class NecklaceSlot extends Model
{
    /** @use HasFactory<\Database\Factories\NecklaceSlotFactory> */
    use HasFactory;
    use HasApiTokens;

protected $guarded = [];
    public function users()
    {
        return $this->belongsToMany(User::class, 'necklace_slot_users')
                    ->withTimestamps();
    }
}
