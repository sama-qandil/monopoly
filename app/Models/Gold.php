<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gold extends Model
{
    /** @use HasFactory<\Database\Factories\GoldFactory> */
    use HasFactory;


    public function users() {
    return $this->belongsToMany(User::class, 'user_gold', 'gold_id', 'user_id');
}
}

