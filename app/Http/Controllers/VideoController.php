<?php

namespace App\Http\Controllers;

use App\Models\video;
use App\Http\Requests\StorevideoRequest;
use App\Http\Requests\UpdatevideoRequest;
use App\Http\Resources\teacherResource;
use App\Http\Resources\videoCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = JWTAuth::user()->teacher;
        $cacheKey = 'videos_teacher_' . $teacher->id;

        // Paginated version
        // $videos = cache()->remember($cacheKey, 1440, function () use ($teacher) {
        //     return $teacher->videos()->paginate(10);
        // });

        // Non-paginated version
        $videos = cache()->remember($cacheKey . '_all', 1440, function () use ($teacher) {
            return $teacher->videos;
        });

        return ['teacher' => $teacher, 'videos' => $videos];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorevideoRequest $request)
    {
        Gate::authorize('create', video::class);
        $teacher = JWTAuth::user()->teacher;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->storeAs('videos', uniqid() . '_' . $file->getClientOriginalName(), 'public');
            $video = video::create([
                'teacher_id' => $teacher->id,
                'lesson_id' => $request->input('lesson_id'),
                'title' => $request->input('title'),
                'url' => $path,
            ]);

            return response()->json($video, 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(video $video)
    {
        return response()->json($video);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatevideoRequest $request, video $video)
    {
        $video->update($request->validated());
        return response()->json($video);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(video $video)
    {
        Gate::authorize('delete', [video::class, $video]);
        Storage::disk('public')->delete($video->url);
        $video->delete();
        return response()->json(['message' => 'Video deleted successfully']);
    }
}
