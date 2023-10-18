<?php

namespace App\Http\Controllers;

use App\Models\ClassroomSession;
use App\Http\Requests\StoreClassroomSessionRequest;
use App\Http\Requests\UpdateClassroomSessionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClassroomSessionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ClassroomSession::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response | JsonResponse
    {
        if ($request->ajax() || true) {
            $classroomSessions = ClassroomSession::query();
            $classroomSessions = $classroomSessions->with(["classroom", "classroom.course", "season", "lecturer", "lecturer.user", "room"]);

            $classroomSessions = $classroomSessions->where(function ($query) use ($request) {
                // cari id
                $s_id = $request->input('s_id', '');
                if ($s_id) {
                    $query = $query->where('id', $s_id);
                }

                // cari classroom
                $s_classroom = $request->input('s_classroom', '');
                if ($s_classroom) {
                    $classroomSessions = $query->whereHas('classroom', function ($query) use ($s_classroom) {
                        $query->where('name', 'like', '%' . $s_classroom . '%');
                    });
                }

                // cari course
                $s_course = $request->input('s_course', '');
                if ($s_course) {
                    $query = $query->orWhereHas('classroom.course', function ($query) use ($s_course) {
                        $query->where('name', 'like', '%' . $s_course . '%');
                    });
                }

                // cari lecturer
                $s_lecturer = $request->input('s_lecturer', '');
                if ($s_lecturer) {
                    $query = $query->orWhereHas('lecturer.user', function ($query) use ($s_lecturer) {
                        $query->where('name', 'like', '%' . $s_lecturer . '%');
                    });
                }
            });



            $s_sortBy = $request->input('s_sort_by', 'id');
            $s_sortDirection = $request->input('s_sort_direction', 'desc');
            $classroomSessions = $classroomSessions->orderBy($s_sortBy, $s_sortDirection);

            $perPage = $request->input('per_page', 10);
            $classroomSessions = $classroomSessions->paginate($perPage);

            return response()->json($classroomSessions);
        }
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
    public function store(StoreClassroomSessionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassroomSession $classroomSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassroomSession $classroomSession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassroomSessionRequest $request, ClassroomSession $classroomSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassroomSession $classroomSession)
    {
        //
    }
}
