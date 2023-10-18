<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use App\Http\Requests\StoreStudentAttendanceRequest;
use App\Http\Requests\UpdateStudentAttendanceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentAttendanceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(StudentAttendance::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse | Response
    {
        if ($request->ajax()) {
            $studentAttendances = StudentAttendance::query();
            $perPage = $request->input('per_page', 10);

            $studentAttendances = $studentAttendances->paginate($perPage);
            return response()->json($studentAttendances);
        }
        return response()->view('pages.student-attendance.index');
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
    public function store(StoreStudentAttendanceRequest $request)
    {
        $request->validated();

        $studentAttendance = new StudentAttendance();
        $studentAttendance->status = $request->status;
        $studentAttendance->student_id = $request->student_id;
        $studentAttendance->classroom_session_id = $request->classroom_session_id;
        $studentAttendance->save();

        return response()->json([
            'message' => 'Student Attendance created successfully',
            'data' => $studentAttendance,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, StudentAttendance $studentAttendance)
    {
        if ($request->ajax()) {
            // $studentAttendance = StudentAttendance::where('id', $studentAttendance->id)->first();
            return response()->json($studentAttendance);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentAttendanceRequest $request, StudentAttendance $studentAttendance)
    {
        $request->validated();

        $studentAttendance->status = $request->status;
        $studentAttendance->student_id = $request->student_id;
        $studentAttendance->classroom_session_id = $request->classroom_session_id;
        $studentAttendance->save();

        return response()->json([
            'message' => 'Student Attendance updated successfully',
            'data' => $studentAttendance,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, StudentAttendance $studentAttendance)
    {
        $studentAttendance->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Student Attendance deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
