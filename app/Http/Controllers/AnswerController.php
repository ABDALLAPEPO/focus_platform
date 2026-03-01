<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Http\Resources\AnswerCollection;
use App\Http\Resources\QuizAttemptCollection;
use App\Models\Answer;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Video;
use Tymon\JWTAuth\Facades\JWTAuth;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = JWTAuth::user()->student;
        $cacheKey = 'quiz_attempts_student_' . $student->id;

        // Paginated version
        // $quizAttempts = cache()->remember($cacheKey, 1440, function () use ($student) {
        //     return $student->quizzesAttempt()->paginate(10);
        // });

        // Non-paginated version
        $quizAttempts = cache()->remember($cacheKey . '_all', 60, function () use ($student) {
            return $student->quizzesAttempt;
        });

        return ['quizzesAttempt' => new QuizAttemptCollection($quizAttempts)];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnswerRequest $request, Subject $subject, Teacher $teacher, Lesson $lesson, Video $video, Quiz $quiz)
    {
        $answers = $request->validated();
        $student = JWTAuth::user()->student;
        if ($student->quizzesAttempt()->where('quiz_id', $quiz->id)->exists()) {
            return response()->json([
                'message' => 'you attempt this quiz ',
            ]);
        }

        $score = 0;
        for ($i = 0; $i < $quiz->questions->count(); $i++) {

            if (isset($answers['answers'][$i])) {

                $answer_question_id = $answers['answers'][$i]['question_id'];

                $quiz_question = $quiz->questions->where('id', $answer_question_id)->first();
                // dd($quiz_question);
                if ($quiz_question->correct_answer == $answers['answers'][$i]['answer_text']) {
                    $score += 1;
                }
                $answer = answer::create([
                    'quiz_id' => $quiz->id,
                    'question_id' => $answers['answers'][$i]['question_id'],
                    'student_id' => $student->id,
                    'answer_text' => $answers['answers'][$i]['answer_text'],
                    'correctness' => $quiz_question->correct_answer == $answers['answers'][$i]['answer_text'] ?? false,
                ]);
            }
        }
        $quizAttempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'student_id' => $student->id,
            'score' => $score,
        ]);
        $s_q_answers = Answer::where('quiz_id', $quiz->id)->where('student_id', $student->id)->get();

        return ['answers' => new AnswerCollection($s_q_answers), 'score' => $score];
    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
