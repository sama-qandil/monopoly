<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    /** @use HasFactory<\Database\Factories\InboxFactory> */
    use HasFactory;



    public function inboxable(){
        return $this->morphTo();
    }


public function friendMessage() {
    return $this->belongsTo(Friend_message::class, 'id', 'id');
}

public function invite() {
    return $this->belongsTo(Friend_invite::class, 'id', 'id');
}

}
