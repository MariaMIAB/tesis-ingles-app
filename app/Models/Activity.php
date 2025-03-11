<?php

namespace App\Models;

use App\Traits\Trashable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes, Trashable;

    protected $fillable = [
        'title',
        'description',
        'link',
        'status',
        'topic_id',
    ];

    // Relación inversa con Topic
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_activity')
                    ->withPivot('score', 'max_score', 'percentage')
                    ->withTimestamps();
    }
    
    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

}


