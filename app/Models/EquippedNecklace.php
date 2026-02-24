<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class EquippedNecklace extends Model
{
    /** @use HasFactory<\Database\Factories\EquippedNecklaceFactory> */
    use HasFactory;
    use HasApiTokens;

protected $guarded = [];
    // TODO: missing fillable

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
