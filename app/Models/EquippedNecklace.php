<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class EquippedNecklace extends Model
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\EquippedNecklaceFactory> */
    use HasFactory;

    protected $fillable = ['user_id','slot_number','user_necklace_id'];
    // TODO: missing fillable

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
