<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'due_date',
        'status',
        'uuid', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid'; 
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($task) {
            $task->uuid = Str::uuid();
        });
    }
}
