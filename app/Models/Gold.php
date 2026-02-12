<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Gold extends Model
{
    /** @use HasFactory<\Database\Factories\GoldFactory> */
    use HasFactory;


    public function users() {
    return $this->belongsToMany(User::class, 'user_gold');
}


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
}

