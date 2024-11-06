<?php

namespace Database\Factories;

use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Semester>
 */
class SemesterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Primer Semestre', 'Segundo Semestre', 'Tercer Semestre']),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'year_id' => Year::inRandomOrder()->first()->id, // Selecciona un año existente aleatorio
        ];
    }
}
