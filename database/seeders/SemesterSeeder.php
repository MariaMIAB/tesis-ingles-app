<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Year::all()->each(function ($year) {
            // Extraer el año inicial del rango
            $startYear = explode('-', $year->name)[0];
        
            // Definir las fechas de inicio y fin para cada semestre
            $semesters = [
                [
                    'name' => 'Primer Trimestre',
                    'start_date' => Carbon::create($startYear, 2, 5), // 5 de febrero
                    'end_date' => Carbon::create($startYear, 5, 10), // 10 de mayo
                ],
                [
                    'name' => 'Segundo Trimestre',
                    'start_date' => Carbon::create($startYear, 5, 13), // 13 de mayo
                    'end_date' => Carbon::create($startYear, 8, 30), // 30 de agosto
                ],
                [
                    'name' => 'Tercer Trimestre',
                    'start_date' => Carbon::create($startYear, 9, 2), // 2 de septiembre
                    'end_date' => Carbon::create($startYear, 12, 4), // 4 de diciembre
                ],
            ];
        
            foreach ($semesters as $semester) {
                Semester::factory()->create([
                    'year_id' => $year->id,
                    'name' => $semester['name'],
                    'start_date' => $semester['start_date'],
                    'end_date' => $semester['end_date'],
                ]);
            }
        });
    }
}
