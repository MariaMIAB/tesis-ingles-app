<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Year extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('withSemesters', function (Builder $builder) {
            $builder->with('semesters');
        });
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_year', 'year_id', 'student_id');
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
