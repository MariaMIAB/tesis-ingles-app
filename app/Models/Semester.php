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
            // Verificar si existe el año antes de proceder
            if (!Year::where('id', $semester->year_id)->exists()) {
                throw new \Exception('El año académico especificado no existe.');
            }
    
            // Contar semestres existentes sin cargar todos los registros
            $existingSemestersCount = Semester::where('year_id', $semester->year_id)->count();
    
            if ($existingSemestersCount >= 3) {
                throw new \Exception('No se pueden agregar más de 3 semestres por año.');
            }
        });
    }
    

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_semester', 'semester_id', 'student_id')->withTimestamps();
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    // 🔹 Agregar relación con Topics
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
 
}