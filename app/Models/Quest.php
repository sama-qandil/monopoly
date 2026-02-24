<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    /** @use HasFactory<\Database\Factories\RewardFactory> */
    use HasFactory;

    // TODO: missing fillable

    public function getAvatarUrlAttribute($value)
    {

        return $value ? asset('storage/quests/'.$value) : asset('images/default_quest.png');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'quest_user')
            ->withTimestamps();
    }
}
