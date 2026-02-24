<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, HasApiTokens;

    protected $guarded = [];
      // TODO: missing fillable
    public function users(){
        return $this->belongsToMany(User::class, 'task_user')
            ->withPivot('current_count', 'is_completed', 'is_collected')
            ->withTimestamps();
    }
}
