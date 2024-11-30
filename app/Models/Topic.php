<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Topic extends Model
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'topic_name',
        'topic_description',
        'semester_id',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function views() { 
        return $this->hasMany(TopicView::class); 
    } 
    
    public function likes() { 
        return $this->hasMany(TopicLike::class); 
    }

    public function activities() { 
        return $this->hasMany(Activity::class); 
    }
}

