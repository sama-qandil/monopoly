<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gold extends Model
{
    /** @use HasFactory<\Database\Factories\GoldFactory> */
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'gold_user');
    }

    protected function iconUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->icon) {
                    return asset('storage/'.$this->icon);
                }

                return asset('storage/default.png');
            }

        );

    }

    protected $appends = ['icon_url'];


    public function shopItem()
{
    return $this->morphOne(ShopItem::class, 'itemable');
}
}
