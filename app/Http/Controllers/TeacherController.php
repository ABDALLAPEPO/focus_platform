<?php

namespace App\Http\Controllers;

use App\Models\teacher;
use App\Http\Requests\StoreteacherRequest;
use App\Http\Requests\UpdateteacherRequest;
use App\Http\Resources\quizCollection;
use App\Http\Resources\quizResource;
use App\Http\Resources\teacherCollection;
use App\Http\Resources\teacherResource;
use App\Http\Resources\videoCollection;
use App\Models\lesson;
use App\Models\quiz;
use App\Models\subject;
use App\Models\video;
use Tymon\JWTAuth\Facades\JWTAuth;

use function Symfony\Component\String\s;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(subject $subject)
    {
        return [ 'teachers'=> new teacherCollection($subject->teachers)];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreteacherRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(subject $subject,teacher $teacher)
    {
        // return (new teacherResource($teacher))->additional([ 'videos'=> new videoCollection($teacher->videos)]);
        return ['teacher'=> new teacherResource($teacher),'lessons'=> $teacher->videos->load('lesson:id,title')->pluck('lesson')];
        // return (new teacherResource($teacher))->additional([ 'lessons'=> $teacher->videos->load('lesson:id,title')->pluck('lesson')]);
    }
    public function showContent(subject $subject,teacher $teacher,lesson $lesson)
    {
        return ['teacher'=> new teacherResource($teacher),'videos'=> new videoCollection($teacher->videos)];
        // return (new teacherResource($teacher))->additional([ 'videos'=> new videoCollection($teacher->videos)]);
        // return (new teacherResource($teacher))->additional([ 'lessons'=> $teacher->videos->load('lesson:id,title')->pluck('lesson')]);
    }
    public function showQuiz(subject $subject, teacher $teacher, lesson $lesson,video $video,quiz $quiz)
    {
        // dd($teacher->videos->quiz);
        $student= JWTAuth::user()->student;
// dd($student->quizzesAttempt->where('quiz_id', $quiz->id)->first());
        if($student->quizzesAttempt->where('quiz_id',$quiz->id)->first()){
            return response()->json([
                'message'=>'you attempt this quiz ',
            ]);
        };
        return ['teacher'=> new teacherResource($teacher),'quiz'=> new quizResource($quiz)];
        // return (new teacherResource($teacher))->additional([ 'quiz'=> new quizResource($quiz)]);
        // return (new teacherResource($teacher))->additional([ 'lessons'=> $teacher->videos->load('lesson:id,title')->pluck('lesson')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateteacherRequest $request, teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(teacher $teacher)
    {
        //
    }
}
