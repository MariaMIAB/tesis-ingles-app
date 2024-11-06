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

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'topic_likes', 'topic_id', 'user_id');
    }

    public function viewedByUsers()
    {
        return $this->belongsToMany(User::class, 'topic_views', 'topic_id', 'user_id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}

