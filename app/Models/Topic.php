<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_name',
        'topic_description',
        'semester_id',  // Asegúrate de que coincida con el campo en la migración
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
}

