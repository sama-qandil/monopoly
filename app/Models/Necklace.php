<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Necklace extends Model
{
    /** @use HasFactory<\Database\Factories\NecklaceFactory> */
    use HasFactory;



    public function users() {
    return $this->belongsToMany(User::class, 'user_necklace', 'necklace_id', 'user_id');
}
}
