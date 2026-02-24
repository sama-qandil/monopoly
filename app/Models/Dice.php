<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Dice extends Model
{
    // TODO: missing fillable

    use HasApiTokens;

    protected $guarded = [];

    protected $appends = ['icon_url'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
