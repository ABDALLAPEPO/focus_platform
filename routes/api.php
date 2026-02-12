<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\VideoController;
use App\Models\subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
// protected route to get current user
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
// subject routes
// student routes
Route::get('subjects', [SubjectController::class, 'index']);
// Route::get('subjects/{subject}/teachers', [TeacherController::class, 'index']);
Route::get('subjects/{subject}/teachers', [TeacherController::class, 'index']);
Route::get('subjects/{subject}/teachers/{teacher}/lessons', [TeacherController::class, 'show']);
Route::get('subjects/{subject}/teachers/{teacher}/lessons/{lesson}/content', [TeacherController::class, 'showContent']);
Route::get('subjects/{subject}/teachers/{teacher}/lessons/{lesson}/video/{video}/quiz/{quiz}', [TeacherController::class, 'showQuiz'])->middleware(['role:student', 'auth:api']);
Route::post('subjects/{subject}/teachers/{teacher}/lessons/{lesson}/video/{video}/quiz/{quiz}/answers',[AnswerController::class,'store'])->middleware(['role:student','auth:api']);
// Route::get('subjects/{subject}/teachers/{teacher}/videos', [TeacherController::class, 'show']);
Route::get('student/{student}/attempt', [AnswerController::class, 'index'])->middleware(['role:student', 'auth:api']);
Route::get('subjects/{subject}/subtopics', [SubjectController::class, 'showSubtopics']);

//  quiz routes
Route::apiResource('quiz', QuizController::class)->middleware(['auth:api', 'role:teacher']);
// video routes
Route::apiResource('videos', VideoController::class)->middleware(['auth:api', 'role:teacher']);
// upload quiz
// teacher routes
// Route::get('teachers', [TeacherController::class, 'index']);