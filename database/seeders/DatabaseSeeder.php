<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $this->call([
            SubjectSeeder::class,
            UnitSeeder::class,
            LessonSeeder::class,
            SubtopicSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            QuizSeeder::class,
            QuizAttemptSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
            VideoSeeder::class,
        ]);

        // Clear Faker's unique generator to prevent duplicate issues
        FakerFactory::create()->unique(true);
    }
}
