<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreanswerRequest;
use App\Http\Requests\UpdateanswerRequest;
use App\Http\Resources\answerCollection;
use App\Http\Resources\quizAttemptCollection;
use App\Models\answer;
use App\Models\lesson;
use App\Models\quiz;
use App\Models\quizAttempt;
use App\Models\student;
use App\Models\subject;
use App\Models\teacher;
use App\Models\video;
use Tymon\JWTAuth\Facades\JWTAuth;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(student $student)
    {
        $cacheKey = 'quiz_attempts_student_' . $student->id;

        // Paginated version
        // $quizAttempts = cache()->remember($cacheKey, 1440, function () use ($student) {
        //     return $student->quizzesAttempt()->paginate(10);
        // });

        // Non-paginated version
        $quizAttempts = cache()->remember($cacheKey . '_all', 1440, function () use ($student) {
            return $student->quizzesAttempt;
        });

        return ['quizzesAttempt' => $quizAttempts];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreanswerRequest $request, subject $subject, teacher $teacher, lesson $lesson, video $video, quiz $quiz)
    {
        $answers = $request->validated();
        $student = JWTAuth::user()->student;
        if ($student->quizzesAttempt->where('quiz_id', $quiz->id)->first()) {
            return response()->json([
                'message' => 'you attempt this quiz ',
            ]);
        }

        $score = 0;
        for ($i = 0; $i < $quiz->questions->count(); $i++) {

            if (isset($answers['answers'][$i])) {

                $answer_question_id = $answers['answers'][$i]['question_id'];

                $quiz_question = $quiz->questions->where('id', $answer_question_id)->first();

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
        $quizAttempt = quizAttempt::create([
            'quiz_id' => $quiz->id,
            'student_id' => $student->id,
            'score' => $score,
        ]);
        $s_q_answers = answer::where('quiz_id', $quiz->id)->where('student_id', $student->id)->get();

        return ['answers' => new answerCollection($s_q_answers), 'score' => $score];
    }

    /**
     * Display the specified resource.
     */
    public function show(answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateanswerRequest $request, answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(answer $answer)
    {
        //
    }
}
