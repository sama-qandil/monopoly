<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class FriendMessage extends Model
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\FriendMessagesFactory> */
    use HasFactory;

    protected $guarded = [];

    
}
