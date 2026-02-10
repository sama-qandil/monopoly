<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jewelry extends Model
{
    /** @use HasFactory<\Database\Factories\JewelryFactory> */
    use HasFactory;



    public function users() {
    return $this->belongsToMany(User::class, 'user_jewelry', 'jewelry_id', 'user_id');
}
}

