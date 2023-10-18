<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Course::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse | Response
    {
        if ($request->ajax()) {
            $courses = Course::query();
            $perPage = $request->input('per_page', 10);

            $s_id = $request->input('s_id', '');
            if ($s_id) {
                $courses = $courses->where('id', $s_id);
            }
            
            // cari nama
            $s_name = $request->input('s_name', '');
            if ($s_name) {
                $courses = $courses->where('name', 'like', '%' . $s_name . '%');
            }

            $s_sortBy = $request->input('s_sort_by', 'id');
            $s_sortDirection = $request->input('s_sort_direction', 'desc');
            $courses = $courses->orderBy($s_sortBy, $s_sortDirection);

            $perPage = $request->input('per_page', 10);
            $courses = $courses->paginate($perPage);

            return response()->json($courses);
        }
        return response()->view('pages.course.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $request->validated();

        $course = new Course();
        $course->code = $request->code;
        $course->name = $request->name;
        $course->credits = $request->credits;
        $course->major_id = $request->major_id;
        $course->faculty_id = $request->faculty_id;
        $course->save();

        return response()->json([
            'message' => 'Course created successfully',
            'data' => $course,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Course $course)
    {
        if ($request->ajax()) {
            $course = Course::where('id', $course->id)->with(['major', 'major.faculty'])->first();
            return response()->json($course);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $request->validated();

        $course->code = $request->code;
        $course->name = $request->name;
        $course->credits = $request->credits;
        $course->major_id = $request->major_id;
        $course->faculty_id = $request->faculty_id;
        $course->save();

        return response()->json([
            'message' => 'Course updated successfully',
            'data' => $course,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Course $course)
    {
        $course->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Course deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
