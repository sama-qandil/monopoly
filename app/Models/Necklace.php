<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Sanctum\HasApiTokens;

class Necklace extends Model
{
    /** @use HasFactory<\Database\Factories\NecklaceFactory> */
    use HasFactory;
    use HasApiTokens;

protected $guarded = [];

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
    return $this->belongsToMany(User::class, 'necklace_user', 'necklace_id', 'user_id');
}
}
