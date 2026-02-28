<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemMessage extends Model // TODO: wrong naming for the model
{
    /** @use HasFactory<\Database\Factories\SystemMessageFactory> */
    use HasFactory;

    protected $fillable = ['title', 'content', 'delivered_at'];
    // TODO: missing fillable

    public function users()
    {
        return $this->belongsToMany(User::class, 'system_message_user', 'system_message_id', 'user_id');
    }
}
