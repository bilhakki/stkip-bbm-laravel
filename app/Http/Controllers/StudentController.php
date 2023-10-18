<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Student::class, 'student');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response | JsonResponse
    {
        // $test = Cookie::get('filter-student-faculty');
        // dd($test);
        // $faculties = Faculty::with(['majors'])->get();
        // // dd($faculties);
        // $faculty = $faculties->random();
        // // dd($faculty);
        // dd($faculty->majors);
        // dd($faculty->majors->random()->id);

        if ($request->ajax()) {
            $students = Student::query();
            $students = $students->with(["user", "major", "major.faculty"]);

            $role = auth()->user()->role;
            if ($role === UserRole::ACADEMIC_FACULTY) {
                $faculty_id = auth()->user()->academic->academicable_id;
                $students = $students->whereHas('major.faculty', function ($query) use ($faculty_id) {
                    $query->where('id', $faculty_id);
                });
            } else if ($role === UserRole::ACADEMIC_MAJOR) {
                $major_id = auth()->user()->academic->academicable_id;
                $students = $students->whereHas('major', function ($query) use ($major_id) {
                    $query->where('id', $major_id);
                });
            }

            $s_id = $request->input('s_id', '');
            if ($s_id) {
                $students = $students->where('id', $s_id);
            }

            // cari nama
            $s_name = $request->input('s_name', '');
            if ($s_name) {
                $students = $students->whereHas('user', function ($query) use ($s_name) {
                    $query->where('name', 'like', '%' . $s_name . '%');
                });
            }

            // urutkan
            $s_sortBy = $request->input('s_sort_by', 'id');
            $s_sortDirection = $request->input('s_sort_direction', 'desc');
            $students = $students->orderBy($s_sortBy, $s_sortDirection);

            $perPage = $request->input('per_page', 10);
            $students = $students->paginate($perPage);

            return response()->json($students);
        }

        return response()->view('pages.student.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        $request->validated();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = UserRole::STUDENT;
        $user->save();

        $student = new Student();
        $student->student_id = $request->student_id;
        $student->current_credits = $request->current_credits;
        $student->admission_year = $request->admission_year;
        $student->date_of_birth = $request->date_of_birth;
        $student->gender = $request->gender;
        $student->status = $request->status;
        $student->address = $request->address;
        $student->phone_number = $request->phone_number;
        $student->guardian_name = $request->guardian_name;
        $student->guardian_phone_number = $request->guardian_phone_number;
        $student->blood_type = $request->blood_type;
        $student->tuition_fee = $request->tuition_fee;
        $student->faculty_id = $request->faculty_id;
        $student->major_id = $request->major_id;

        $user->student()->save($student);

        return response()->json([
            'message' => 'Student created successfully',
            'data' => $student,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Student $student)
    {

        if ($request->ajax()) {
            $student = Student::where('id', $student->id)->with(['user', 'major', 'major.faculty'])->first();
            return response()->json($student);
        }
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {

        $user = $student->user;

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) $user->password = Hash::make($request->password);
        $user->save();

        $student->student_id = $request->student_id;
        $student->current_credits = $request->current_credits;
        $student->admission_year = $request->admission_year;
        $student->date_of_birth = $request->date_of_birth;
        $student->gender = $request->gender;
        $student->status = $request->status;
        $student->address = $request->address;
        $student->phone_number = $request->phone_number;
        $student->guardian_name = $request->guardian_name;
        $student->guardian_phone_number = $request->guardian_phone_number;
        $student->blood_type = $request->blood_type;
        $student->tuition_fee = $request->tuition_fee;
        $student->faculty_id = $request->faculty_id;
        $student->major_id = $request->major_id;
        $student->save();

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $student,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Student $student): JsonResponse | RedirectResponse
    {
        $user = $student->user;
        $user->delete();

        $student->delete();
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Student deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
