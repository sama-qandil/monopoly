<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    /** @use HasFactory<\Database\Factories\InboxFactory> */
    use HasFactory;


public function friendMessage() {
    return $this->belongsTo(FriendMsg::class, 'id', 'id');
}

public function invite() {
    return $this->belongsTo(FriendInvite::class, 'id', 'id');
}

}
