<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quiz;
use App\Models\Subtopic;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\question>
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
        return [
            'quiz_id' => Quiz::factory(),
            'subtopic_id' => Subtopic::inRandomOrder()->value('id'),
            'question' => $this->faker->sentence(),
            'option_1' => $this->faker->word(),
            'option_2' => $this->faker->word(),
            'option_3' => $this->faker->word(),
            'option_4' => $this->faker->word(),
            'correct_answer' => $this->faker->randomElement(['option_1', 'option_2', 'option_3', 'option_4']),
        ];
    }
}
