<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['title', 'description', 'type', 'topic_id', 'visibility', 'duration', 'semester_id', 'year_id'];

    // Relación con preguntas
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relación con el tema
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    // Relación con las respuestas de los usuarios
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    // Relación con los usuarios que han tomado el examen
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_exams')->withPivot('score')->withTimestamps();
    }

    // Relación con el semestre
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    // Relación con el año (si es necesario)
    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
