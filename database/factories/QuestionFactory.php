<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quiz;
use App\Models\Subtopic;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quiz = Quiz::inRandomOrder()->first();

        // Scope subtopic to the quiz's lesson
        $subtopicId = Subtopic::where('lesson_id', $quiz->lesson_id)
            ->inRandomOrder()
            ->value('id');

        return [
            'quiz_id'        => $quiz->id,
            'subtopic_id'    => $subtopicId,
            'question'       => $this->faker->sentence(),
            'option_1'       => $this->faker->word(),
            'option_2'       => $this->faker->word(),
            'option_3'       => $this->faker->word(),
            'option_4'       => $this->faker->word(),
            'correct_answer' => $this->faker->randomElement(['option_1', 'option_2', 'option_3', 'option_4']),
        ];
    }
}
