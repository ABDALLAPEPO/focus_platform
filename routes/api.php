<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubtopicController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\VideoController;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Lesson;
use App\Models\Video;
use App\Models\Quiz;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
// Apply middleware to all routes
Route::middleware('auth:api')->group(function () {
    // Auth routes
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // Subject routes
    // Route::get('subjects/{subject}/teachers/{teacher}/videos/{video}', [TeacherController::class, 'test'])->scopeBindings();

    Route::get('subjects', [SubjectController::class, 'index']);
    Route::get('subjects/{subject}/teachers', [TeacherController::class, 'index']);
    Route::get('subjects/{subject}/teachers/{teacher}/lessons', [TeacherController::class, 'show']);
    Route::get('subjects/{subject}/teachers/{teacher}/lessons/{lesson}/content', [TeacherController::class, 'showContent'])->scopeBindings();
    Route::get('subjects/{subject}/teachers/{teacher}/lessons/{lesson}/videos/{video}/quizzes/{quiz}', [TeacherController::class, 'showQuiz'])->scopeBindings();
    

    Route::post('subjects/{subject}/teachers/{teacher}/lessons/{lesson}/videos/{video}/quizzes/{quiz}/answers', [AnswerController::class, 'store']);
    Route::get('students/attempts', [AnswerController::class, 'index'])->middleware(['role:student']);
    Route::get('subjects/{subject}/subtopics', [SubjectController::class, 'showSubtopics']);

    // Quiz routes
    Route::apiResource('quizzes', QuizController::class)->middleware(['role:teacher']);
    // Route::get('quizzes', [QuizController::class, 'getAllQuizzes']);
    Route::get('quizzes/{quiz}/questions/{question}', [QuizController::class, 'getQuestion']);

    // Video routes
    Route::apiResource('videos', VideoController::class)->middleware(['role:teacher']);
});

// Route::middleware(['auth:api', 'role:teacher'])->group(function () {
//     Route::apiResource('subjects', SubjectController::class);

//     Route::prefix('subjects/{subject}')->group(function () {
//         Route::apiResource('subtopics', SubtopicController::class);
//     });
// });
