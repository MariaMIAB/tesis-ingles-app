<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Year>
 */
class YearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = $this->faker->year;
            return [
                'name' => $startYear . '-' . ($startYear + 1),
                'start_date' => $this->faker->dateTimeBetween($startYear . '-02-01', $startYear . '-02-28')->format('Y-m-d'),
                'end_date' => $this->faker->dateTimeBetween($startYear . '-12-01', $startYear . '-12-31')->format('Y-m-d'),
            ];
    }
}
