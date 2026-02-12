<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lesson;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\subtopic>
 */
class SubtopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'lesson_id' => Lesson::factory(),
            // 'title' => $this->faker->sentence(),
        ];
    }
}
