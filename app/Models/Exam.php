<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['title', 'description', 'type', 'topic_id', 'visible', 'duration'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_exams')->withPivot('score')->withTimestamps();
    }

}