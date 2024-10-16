<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_year', 'year_id', 'student_id');
    }

    // Relación uno a muchos con Semester
    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
