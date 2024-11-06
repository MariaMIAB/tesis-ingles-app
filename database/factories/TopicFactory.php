<?php

namespace Database\Factories;
namespace Database\Factories;

use App\Models\Topic;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition()
    {
        return [
            'topic_name' => $this->faker->sentence,
            'topic_description' => $this->faker->paragraph,
            'semester_id' => Semester::inRandomOrder()->first()->id,
        ];
    }
}
