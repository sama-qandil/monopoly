<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gem extends Model
{
    /** @use HasFactory<\Database\Factories\GemFactory> */
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'gem_user', 'gem_id', 'user_id');
    }


    public function shopItem()
{
    return $this->morphOne(ShopItem::class, 'itemable');
}
}
