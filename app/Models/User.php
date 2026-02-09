<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\GeneralCharacter;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   
    protected $fillable = [
        'device_id',
        'username',
        'email',
        'password',
        'gold',
        'gems',
        'avatar',
        'total_matches',
        'wins',
        'losses',
        'level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }






public function characters() {
    return $this->belongsToMany(Character::class, 'character_user', 'user_id', 'character_id')
                ->withPivot('current_level', 'current_experience', 'is_selected');
}

public function dices() {
    return $this->belongsToMany(Dice::class, 'user_dice');
}

public function golds() {
    return $this->belongsToMany(Gold::class, 'user_gold');
}


public function jewelries() {
    return $this->belongsToMany(Jewelry::class, 'user_jewelry');
}


public function necklaces() {
    return $this->belongsToMany(Necklace::class, 'user_necklace');
}



public function tasks() {
    return $this->belongsToMany(Task::class, 'user_task_progress')
                ->withPivot('current_progress', 'is_claimed');
}

public function claimedRewards() {
    return $this->belongsToMany(Reward::class, 'user_reward_claims')
                ->withTimestamps(); 
}

public function inbox() {
    return $this->hasMany(Inbox::class);
}


// public function favoriteCharacter() {
//     return $this->belongsTo(GeneralCharacter::class, 'fav_character_id');
// }

// public function equippedNecklaces() {
//     return $this->hasMany(UserEquippedNecklace::class);
// }



public function matches() {
    return $this->belongsToMany(Matchh::class, 'matchh_user', 'user_id', 'matchh_id')
                ->withPivot('gold_gained', 'gems_gained', 'rank', 'wins', 'loss', 'experience_gained', 'character_id')
                ->withTimestamps();
}

}