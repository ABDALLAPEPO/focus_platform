<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\answer>
 */
class AnswerFactory extends Factory
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
            'question_id' => Question::factory(),
            'answer_text' => $this->faker->sentence(),
            'correctness' => $this->faker->boolean(),
        ];
    }
}
