<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quest;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

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
