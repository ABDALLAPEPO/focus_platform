<?php

namespace App\Http\Controllers;

use App\Models\quiz;
use App\Http\Requests\StorequizRequest;
use App\Http\Requests\UpdatequizRequest;
use App\Http\Resources\quizCollection;
use App\Http\Resources\quizResource;
use App\Models\question;
use App\Models\video;

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
        $cacheKey = 'quizzes_teacher_' . $teacher->id;

        // Paginated version
        // $quizzes = cache()->remember($cacheKey, 1440, function () use ($teacher) {
        //     return $teacher->quizzes()->paginate(10);
        // });

        // Non-paginated version
        $quizzes = cache()->remember($cacheKey . '_all', 1440, function () use ($teacher) {
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
        $video = video::find($questions['video_id']);
        Gate::authorize('create', [quiz::class, $video]);
        $quiz = quiz::create([
            'lesson_id' => $video->lesson_id,
            'teacher_id' => JWTAuth::user()->teacher->id,
            'video_id' => $questions['video_id'],
        ]);
        foreach ($questions['questions'] as $q) {
            question::create([
                'quiz_id' => $quiz->id,
                'question' => $q['question'],
                'subtopic_id' => $q['subtopic_id'],
                'option_1' => $q['option'][0],
                'option_2' => $q['option'][1],
                'option_3' => $q['option'][2],
                'option_4' => $q['option'][3],
                'correct_answer' => $q['correct_answer'],
            ]);
        }
        return ['quiz' => new quizResource($quiz)];
    }

    /**
     * Display the specified resource.
     */
    public function show(quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatequizRequest $request, quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(video $video, quiz $quiz)
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
        $quizzes = quiz::all();
        return response()->json(['quizzes' => quizResource::collection($quizzes), 'count' => $quizzes->count()]);
    }

    /**
     * Get a specific question for a quiz.
     */
    public function getQuestion(quiz $quiz, question $question)
    {
        if ($question->quiz_id !== $quiz->id) {
            return response()->json(['error' => 'Question does not belong to the specified quiz'], 404);
        }

        return response()->json(['question' => new quizResource($question)]);
    }
}
