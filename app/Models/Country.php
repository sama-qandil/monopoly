<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Country extends Model
{
 
protected function flagUrl(): Attribute
{
    return Attribute::make(
        get: fn() => asset('images/flags/' . $this->flag_icon)
    );
}

protected $appends = ['flag_url'];
}
