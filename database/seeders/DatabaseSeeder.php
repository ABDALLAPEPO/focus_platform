<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Spatie\Permission\Models\Role;

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
            RoleSeeder::class,
            SubjectSeeder::class,
            UnitSeeder::class,
            LessonSeeder::class,
            SubtopicSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            VideoSeeder::class,
            QuizSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            QuizAttemptSeeder::class,
        ]);

        // Clear Faker's unique generator to prevent duplicate issues
        FakerFactory::create()->unique(true);
    }
}
