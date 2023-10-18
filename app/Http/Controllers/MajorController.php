<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Major;
use App\Http\Requests\StoreMajorRequest;
use App\Http\Requests\UpdateMajorRequest;
use App\Models\Faculty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class MajorController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Major::class);
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request): JsonResponse | Response
    {
        if ($request->ajax()) {
            $majors = Major::query();
            $majors = $majors->with(["faculty"]);

            $role = auth()->user()->role;
            if ($role === UserRole::ACADEMIC_FACULTY) {
                $faculty_id = auth()->user()->academic->academicable_id;
                $majors = $majors->whereHas('faculty', function ($query) use ($faculty_id) {
                    $query->where('id', $faculty_id);
                });
            } else if ($role === UserRole::ACADEMIC_MAJOR) {
                $major_id = auth()->user()->academic->academicable_id;
                $majors = $majors->where("id", $major_id);
            }

            $majors = $majors->get();
            return response()->json($majors);
            // return response()->json(Cache::get('majors'));
        }

        $faculties = Faculty::all();

        return response()->view('pages.major.index', compact('faculties'));
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
    public function store(StoreMajorRequest $request)
    {
        $request->validated();

        $major = new Major();
        $major->name = $request->name;
        $major->faculty_id = $request->faculty_id;
        $major->save();

        Cache::forever('majors', Major::all());

        return response()->json([
            'message' => 'Major created successfully',
            'data' => $major,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Major $major)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Major $major)
    {
        if ($request->ajax()) {
            $major = Major::where('id', $major->id)->with(['faculty'])->first();
            return response()->json($major);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMajorRequest $request, Major $major)
    {
        $request->validated();

        $major->name = $request->name;
        $major->faculty_id = $request->faculty_id;
        $major->save();

        Cache::forever('majors', Major::all());

        return response()->json([
            'message' => 'Major updated successfully',
            'data' => $major,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Major $major)
    {
        $major->delete();

        Cache::forever('majors', Major::all());

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Major deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
