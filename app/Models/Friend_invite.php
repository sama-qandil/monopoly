<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Friend_invite extends Model
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\FriendInviteFactory> */
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'status','delivered_at']; 
    // TODO: missing fillable

    public function inboxes()
    {
        return $this->hasMany(User::class);
    }
}
