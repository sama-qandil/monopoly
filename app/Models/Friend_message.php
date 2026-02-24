<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Friend_message extends Model
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\FriendMessagesFactory> */
    use HasFactory;

    protected $guarded = [];

    public function inboxes()
    {

        return $this->morphMany(Inbox::class, 'inboxable');
    }
}
