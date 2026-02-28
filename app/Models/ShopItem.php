<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ShopItem extends Model
{
    /** @use HasFactory<\Database\Factories\ShopItemFactory> */
    use HasFactory,HasApiTokens;
    protected $fillable = ['category', 'itemable_id', 'itemable_type', 'price', 'currency_type', 'is_active', 'discount_percentage'];


    public function itemable()
{
    return $this->morphTo();
}
}
