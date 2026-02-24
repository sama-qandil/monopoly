<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Country extends Model
{
    use HasApiTokens;

    protected $guarded = [];

    protected function flagUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset('images/flags/'.$this->flag_icon)
        );
    }

    protected $appends = ['flag_url'];
}
