<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jewelry extends Model
{
    /** @use HasFactory<\Database\Factories\JewelryFactory> */
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'jewelry_user', 'jewelry_id', 'user_id');
    }


    public function shopItem()
{
    return $this->morphOne(ShopItem::class, 'itemable');
}
}
