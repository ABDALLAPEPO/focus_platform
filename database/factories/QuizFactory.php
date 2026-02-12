<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\Video;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lesson_id' => $this->faker->randomElement(Lesson::pluck('id')->toArray()),
            'teacher_id' => Teacher::factory(),
            'video_id' => Video::factory(),
        ];
    }
}
