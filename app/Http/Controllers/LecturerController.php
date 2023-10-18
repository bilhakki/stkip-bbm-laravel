<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Lecturer;
use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Lecturer::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        if ($request->ajax()) {
            $lecturers = Lecturer::query();
            $perPage = $request->input('per_page', 10);

            $lecturers = $lecturers->paginate($perPage);
            return response()->json($lecturers);
        }
        return response()->view('pages.lecturer.index');
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
    public function store(StoreLecturerRequest $request)
    {
        $request->validated();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = UserRole::LECTURER;
        $user->save();

        $lecturer = new Lecturer();
        $lecturer->position = $request->position;
        $lecturer->specialization = $request->specialization;
        $lecturer->phone_number = $request->phone_number;
        $lecturer->status = $request->status;

        $user->lecturer()->save($lecturer);

        return response()->json([
            'message' => 'Lecturer created successfully',
            'data' => $lecturer,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Lecturer $lecturer)
    {
        if ($request->ajax()) {
            $lecturer = Lecturer::where('id', $lecturer->id)->with(['user'])->first();
            return response()->json($lecturer);
        }
        return view('lecturer.edit', compact('lecturer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLecturerRequest $request, Lecturer $lecturer)
    {
        
        $user = $lecturer->user;

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password) $user->password = Hash::make($request->password);
        $user->save();
        
        $lecturer->position = $request->position;
        $lecturer->specialization = $request->specialization;
        $lecturer->phone_number = $request->phone_number;
        $lecturer->status = $request->status;
        $lecturer->save();

        return response()->json([
            'message' => 'Lecturer updated successfully',
            'data' => $lecturer,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Lecturer $lecturer)
    {
        $user = $lecturer->user;
        $user->delete();

        $lecturer->delete();
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Lecturer deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
