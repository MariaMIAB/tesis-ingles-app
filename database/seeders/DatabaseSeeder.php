<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(yearSeeder::class);
        $this->call(SemesterSeeder::class);

        $years = \App\Models\Year::with('semesters')->get();
        $students = \App\Models\User::role('Estudiante')->get();
        
        $students->each(function ($student) use ($years) {
            $year = $years->random();
            $student->years()->attach($year->id);
        
            $semester = $year->semesters->random();
            $student->semesters()->attach($semester->id);
        });
        
    }
}
