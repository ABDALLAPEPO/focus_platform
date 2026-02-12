<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lesson;
use App\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::factory(),
            'lesson_id' =>$this->faker->randomElement(Lesson::pluck('id')->toArray()),
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
        ];
    }
}
