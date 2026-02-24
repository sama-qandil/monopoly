<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System_message extends Model // TODO: wrong naming for the model
{
    /** @use HasFactory<\Database\Factories\SystemMessageFactory> */
    use HasFactory;

    // TODO: missing fillable

    public function users()
    {
        return $this->belongsToMany(User::class, 'system_message_user', 'system_message_id', 'user_id');
    }
}
