<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Http\Resources\QuizCollection;
use App\Http\Resources\QuizResource;
use App\Models\Question;
use App\Models\Video;

use Illuminate\Support\Facades\Gate;
use Tymon\JWTAuth\Facades\JWTAuth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = JWTAuth::user()->teacher;
        // return $teacher;
        $cacheKey = 'quizzes_teacher_' . $teacher->id;

        // Paginated version
        // $quizzes = cache()->remember($cacheKey, 1440, function () use ($teacher) {
        //     return $teacher->quizzes()->paginate(10);
        // });

        // Non-paginated version
        $quizzes = cache()->remember($cacheKey . '_all', 60, function () use ($teacher) {
            return $teacher->quizzes;
        });

        return ['quizzes' => $quizzes];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorequizRequest $request)
    {

        $questions = $request->validated();
        $video = Video::findOrFail($questions['video_id']);
        Gate::authorize('create', [Quiz::class, $video]);
        $quiz = Quiz::create([
            'lesson_id' => $video->lesson_id,
            'teacher_id' => JWTAuth::user()->teacher->id,
            'video_id' => $questions['video_id'],
        ]);

        $questionsData = array_map(function ($q) use ($quiz) {
            return [
                'quiz_id' => $quiz->id,
                'question' => $q['question'],
                'subtopic_id' => $q['subtopic_id'],
                'option_1' => $q['option'][0],
                'option_2' => $q['option'][1],
                'option_3' => $q['option'][2],
                'option_4' => $q['option'][3],
                'correct_answer' => $q['correct_answer'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $questions['questions']);

        Question::insert($questionsData);

        return ['quiz' => new QuizResource($quiz)];
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video, Quiz $quiz)
    {
        $quiz->delete();
        return response()->json([
            "message" => "the quiz deleted successfully"
        ]);
    }

    /**
     * Get all quizzes.
     */
    public function getAllQuizzes()
    {
        $quizzes = Quiz::all();
        return response()->json(['quizzes' => QuizResource::collection($quizzes), 'count' => $quizzes->count()]);
    }

    /**
     * Get a specific question for a quiz.
     */
    public function getQuestion(Quiz $quiz, Question $question)
    {
        if ($question->quiz_id !== $quiz->id) {
            return response()->json(['error' => 'Question does not belong to the specified quiz'], 404);
        }

        return response()->json(['question' => new QuizResource($question)]);
    }
}
