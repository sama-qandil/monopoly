<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = []; // TODO: better use fillable

    protected $attributes = [
        'gold' => '0',
        'gems' => '0',
        'avatar' => 'default.png',
        'wins' => '0',
        'loses' => '0',
    ];

    // ============================================================ //
    // TODO: use only one way to write accessors and attributes
    public function totalMatches(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->wins + $this->loses,
        );
    }

    public function getAvatarUrlAttribute($value)
    {

        return $value ? asset('storage/users/'.$value) : asset('images/default_user.png');
    }
    // ============================================================ //

    protected $appends = ['avatar_url'];

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

    public function characters()
    {
        return $this->belongsToMany(Character::class)
            ->withPivot('current_level', 'current_experience', 'is_selected');
    }

    public function dices()
    {
        return $this->belongsToMany(Dice::class, 'dice_user');
    }

    public function gold()
    {
        return $this->belongsToMany(Gold::class, 'gold_user');
    }

    public function jewelries()
    {
        return $this->belongsToMany(Jewelry::class, 'jewelry_user');
    }

    public function necklaces()
    {
        return $this->belongsToMany(Necklace::class, 'necklace_user');
    }




    public function friendInvites()
    {
        return $this->hasMany(Friend_invite::class, 'receiver_id');
    }

    public function systemMessages()
    {
        return $this->belongsToMany(System_message::class, 'system_message_user', 'user_id', 'system_message_id');
    }

    public function friendMessages()
    {
        return $this->hasMany(Friend_message::class, 'receiver_id');
    }

    public function favoriteCharacter()
    {
        return $this->belongsTo(Character::class, 'fav_character_id');
    }

    public function equippedNecklaces()
    {
        return $this->hasMany(EquippedNecklace::class);
    }

    public function matches()
    {
        return $this->belongsToMany(MatchGame::class, 'match_user', 'user_id', 'match_id')
            ->withPivot('gold_gained', 'gems_gained', 'rank', 'wins', 'loss', 'experience_gained', 'character_id')
            ->withTimestamps();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user')
            ->withPivot('current_count', 'is_completed', 'is_collected')
            ->withTimestamps();
    }

    public function unlockedSlots()
    {
        return $this->belongsToMany(Necklaceslot::class, 'necklace_slot_users')
                    ->withTimestamps();
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_user')
            ->withTimestamps();
    }

    public function quests()
    {
        return $this->belongsToMany(Quest::class, 'quest_user')
            ->withTimestamps();
    }
}
