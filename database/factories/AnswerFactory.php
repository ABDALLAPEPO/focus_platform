<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
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
        // Pick a random question first, then derive quiz_id from it
        $question = Question::inRandomOrder()->first();

        return [
            'quiz_id'     => $question->quiz_id,
            'student_id'  => Student::inRandomOrder()->value('id'),
            'question_id' => $question->id,
            'answer_text' => $this->faker->sentence(),
            'correctness' => $this->faker->boolean(),
        ];
    }
}
