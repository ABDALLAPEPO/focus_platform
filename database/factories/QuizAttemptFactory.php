<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quiz;
use App\Models\Student;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\quizAttempt>
 */
class QuizAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'student_id' => Student::factory(),
            'score' => $this->faker->numberBetween(0, 100),
            // 'completed_at' => $this->faker->dateTime(),
        ];
    }
}
