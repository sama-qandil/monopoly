<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Dice extends Model
{
    // TODO: missing fillable

    use HasApiTokens;

    protected $fillable = ['name', 'icon','description', 'gems_cost'];

    protected $appends = ['icon_url'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function shopItem()
{
    return $this->morphOne(ShopItem::class, 'itemable');
}
}
