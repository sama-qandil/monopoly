<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Friend_invite extends Model
{
/** @use HasFactory<\Database\Factories\FriendInviteFactory> */
use HasFactory;
use HasApiTokens;

protected $guarded = [];
    // TODO: missing fillable

    public function inboxes()
    {
        return $this->hasMany(User::class);
    }
}
