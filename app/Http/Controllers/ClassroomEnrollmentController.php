<?php

namespace App\Http\Controllers;

use App\Models\ClassroomEnrollment;
use App\Http\Requests\StoreClassroomEnrollmentRequest;
use App\Http\Requests\UpdateClassroomEnrollmentRequest;

class ClassroomEnrollmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ClassroomEnrollment::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreClassroomEnrollmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassroomEnrollment $classroomEnrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassroomEnrollment $classroomEnrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassroomEnrollmentRequest $request, ClassroomEnrollment $classroomEnrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassroomEnrollment $classroomEnrollment)
    {
        $this->authorize('delete', $classroomEnrollment);
    }
}
