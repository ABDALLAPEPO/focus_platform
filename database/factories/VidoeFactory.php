<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lesson;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\vidoe>
 */
class VidoeFactory extends Factory
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
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'duration' => $this->faker->numberBetween(60, 3600),
        ];
    }
}
