<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class NecklaceSlotUser extends Model
{
    /** @use HasFactory<\Database\Factories\NecklaceSlotUserFactory> */
    use HasFactory;
    use HasApiTokens;

protected $guarded = [];
}
