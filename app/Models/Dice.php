<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Dice extends Model
{

    protected function iconUrl(): Attribute
{
    return Attribute::make(
        get:function(){
            if($this->icon){
                return asset('storage/' . $this->icon);
            }

            return asset('storage/default.png');
        }

    );

}

protected $appends = ['icon_url'];







    public function users() {
    return $this->belongsToMany(User::class, );
}



}

