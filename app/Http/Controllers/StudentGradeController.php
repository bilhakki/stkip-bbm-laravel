<?php

namespace App\Http\Controllers;

use App\Models\StudentGrade;
use App\Http\Requests\StoreStudentGradeRequest;
use App\Http\Requests\UpdateStudentGradeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentGradeController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(StudentGrade::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse | Response
    {
        // dd($_COOKIE);
        if ($request->ajax()) {
            $studentGrades = StudentGrade::query();
            $perPage = $request->input('per_page', 10);

            $studentGrades = $studentGrades->paginate($perPage);
            return response()->json($studentGrades);
        }
        return response()->view('pages.student-grade.index');
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
    public function store(StoreStudentGradeRequest $request)
    {
        $request->validated();

        $studentGrade = new StudentGrade();
        $studentGrade->user_id = auth()->id;
        $studentGrade->grade = $request->grade;
        $studentGrade->student_id = $request->student_id;
        $studentGrade->course_id = $request->course_id;
        $studentGrade->classroom_id = $request->classroom_id;
        $studentGrade->season_id = $request->season_id;
        $studentGrade->save();

        return response()->json([
            'message' => 'Student Grade created successfully',
            'data' => $studentGrade,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentGrade $studentGrade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, StudentGrade $studentGrade)
    {
        if ($request->ajax()) {
            // $studentGrade = StudentGrade::where('id', $studentGrade->id)->first();
            return response()->json($studentGrade);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentGradeRequest $request, StudentGrade $studentGrade)
    {
        $request->validated();

        $studentGrade->user_id = auth()->id;
        $studentGrade->grade = $request->grade;
        $studentGrade->student_id = $request->student_id;
        $studentGrade->course_id = $request->course_id;
        $studentGrade->classroom_id = $request->classroom_id;
        $studentGrade->season_id = $request->season_id;
        $studentGrade->save();

        return response()->json([
            'message' => 'Student Grade updated successfully',
            'data' => $studentGrade,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, StudentGrade $studentGrade)
    {
        $studentGrade->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Student Grade deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
