<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Event extends Model
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $guarded = [];
    // TODO: missing fillable

    public function quests()
    {
        return $this->hasMany(Quest::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->withTimestamps();
    }
}
