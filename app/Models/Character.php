<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Character extends Model
{
    /** @use HasFactory<\Database\Factories\CharacterFactory> */
    use HasApiTokens,HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('current_level', 'current_experience', 'is_selected');
    }


    public function shopItem()
{
    return $this->morphOne(ShopItem::class, 'itemable');
}
}
