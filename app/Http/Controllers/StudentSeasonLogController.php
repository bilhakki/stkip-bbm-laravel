<?php

namespace App\Http\Controllers;

use App\Models\StudentSeasonLog;
use App\Http\Requests\StoreStudentSeasonLogRequest;
use App\Http\Requests\UpdateStudentSeasonLogRequest;

class StudentSeasonLogController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(StudentSeasonLog::class);
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
    public function store(StoreStudentSeasonLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentSeasonLog $studentSeasonLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentSeasonLog $studentSeasonLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentSeasonLogRequest $request, StudentSeasonLog $studentSeasonLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentSeasonLog $studentSeasonLog)
    {
        //
    }
}
