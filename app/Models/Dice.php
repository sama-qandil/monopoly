<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dice extends Model
{
    public function users() {
    return $this->belongsToMany(User::class, 'user_dice', 'dice_id', 'user_id');
}
}

