<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Dice extends Model
{



public function getIconUrlAttribute($value)
{

    return $value ? asset('storage/dices/' . $value) : asset('images/default_dice.png');
}

protected $appends = ['icon_url'];







    public function users() {
    return $this->belongsToMany(User::class, );
}



}

