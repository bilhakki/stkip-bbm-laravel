<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClassroomController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Classroom::class, 'classroom');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse | Response
    {
        if ($request->ajax()) {
            $classrooms = Classroom::query();
            $perPage = $request->input('per_page', 10);

            $s_id = $request->input('s_id', '');
            if ($s_id) {
                $classrooms = $classrooms->where('id', $s_id);
            }

            $s_course_id = $request->input('s_course_id', '');
            if ($s_course_id) {
                $classrooms = $classrooms->where('course_id', $s_course_id);
            }

            // cari nama
            $s_name = $request->input('s_name', '');
            if ($s_name) {
                $classrooms = $classrooms->where('name', 'like', '%' . $s_name . '%');
            }

            $s_sortBy = $request->input('s_sort_by', 'id');
            $s_sortDirection = $request->input('s_sort_direction', 'desc');
            $classrooms = $classrooms->orderBy($s_sortBy, $s_sortDirection);

            $perPage = $request->input('per_page', 10);
            $classrooms = $classrooms->paginate($perPage);
            return response()->json($classrooms);
        }
        return response()->view('pages.classroom.index');
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
    public function store(StoreClassroomRequest $request)
    {
        $request->validated();

        $classroom = new Classroom();
        $classroom->name = $request->name;
        $classroom->credits = $request->credits;
        $classroom->capacity = $request->capacity;
        $classroom->season_id = $request->season_id;
        $classroom->course_id = $request->course_id;
        $classroom->save();

        return response()->json([
            'message' => 'Classroom created successfully',
            'data' => $classroom,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Classroom $classroom)
    {
        if ($request->ajax()) {
            return response()->json($classroom);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassroomRequest $request, Classroom $classroom)
    {
        $request->validated();

        $classroom->name = $request->name;
        $classroom->credits = $request->credits;
        $classroom->capacity = $request->capacity;
        $classroom->season_id = $request->season_id;
        $classroom->course_id = $request->course_id;
        $classroom->save();

        return response()->json([
            'message' => 'Classroom updated successfully',
            'data' => $classroom,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Classroom $classroom)
    {
        $classroom->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Classroom deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
