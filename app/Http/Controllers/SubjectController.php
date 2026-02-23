<?php

namespace App\Http\Controllers;

use App\Models\subject;
use App\Http\Requests\StoresubjectRequest;
use App\Http\Requests\UpdatesubjectRequest;
use App\Http\Resources\teacherCollection;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cacheKey = 'subjects_all';

        // Paginated version
        // $subjects = cache()->remember($cacheKey, 1440, function () {
        //     return subject::paginate(10);
        // });

        // Non-paginated version
        $subjects = cache()->remember($cacheKey . '_all', 1440, function () {
            return subject::all();
        });

        return $subjects;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoresubjectRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(subject $subject)
    {
        return new teacherCollection($subject->teachers);
    }
    public function showSubtopics(subject $subject)
    {
        return $subject->load([
            'units:id,title,subject_id',
            'units.lessons:id,title,unit_id',
            'units.lessons.subtopics:id,title,lesson_id'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesubjectRequest $request, subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subject $subject)
    {
        //
    }
}
