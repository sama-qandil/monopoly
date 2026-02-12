<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend_message extends Model
{
    /** @use HasFactory<\Database\Factories\FriendMessagesFactory> */
    use HasFactory;


    public function inboxes()
{
 
    return $this->morphMany(Inbox::class, 'inboxable');
}
}
