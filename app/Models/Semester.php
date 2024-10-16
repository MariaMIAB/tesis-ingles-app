<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'name',
        'start_date',
        'end_date',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($semester) {
            $year = Year::find($semester->year_id);

            // Contar los semestres existentes para el año específico
            $existingSemestersCount = $year->semesters()->count();

            // Verificar si se está intentando agregar más de 3 semestres para el año específico
            if ($existingSemestersCount >= 3) {
                throw new \Exception('No se pueden agregar más de 3 semestres por año.');
            }
        });
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_semester');
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
