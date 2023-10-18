<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Faculty;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Faculty::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse | Response
    {
        if ($request->ajax()) {
            $faculties = Faculty::query();
            $faculties = $faculties->with(["majors"]);

            $role = auth()->user()->role;
            if ($role === UserRole::ACADEMIC_FACULTY) {
                $faculty_id = auth()->user()->academic->academicable_id;
                $faculties = $faculties->where("id", $faculty_id);
            } else if ($role === UserRole::ACADEMIC_MAJOR) {
                $major_id = auth()->user()->academic->academicable_id;
                $faculties = $faculties->whereHas('majors', function ($query) use ($major_id) {
                    $query->where('id', $major_id);
                });
            }
            $faculties = $faculties->get();
            return response()->json($faculties);
            // return response()->json(Cache::get('faculties'));
        }
        return response()->view('pages.faculty.index');
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
    public function store(StoreFacultyRequest $request)
    {
        $request->validated();

        $faculty = new Faculty();
        $faculty->name = $request->name;
        $faculty->save();

        Cache::forever('faculties', Faculty::all());

        return response()->json([
            'message' => 'Faculty created successfully',
            'data' => $faculty,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Faculty $faculty)
    {
        if ($request->ajax()) {
            $faculty = Faculty::where('id', $faculty->id)->first();
            return response()->json($faculty);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $request->validated();

        $faculty->name = $request->name;
        $faculty->save();

        Cache::forever('faculties', Faculty::all());

        return response()->json([
            'message' => 'Faculty updated successfully',
            'data' => $faculty,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Faculty $faculty)
    {
        $faculty->delete();

        Cache::forever('faculties', Faculty::all());

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Faculty deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
