<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Room::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse | Response
    {
        if ($request->ajax()) {
            $rooms = Room::query();
            $perPage = $request->input('per_page', 10);

            $rooms = $rooms->paginate($perPage);
            return response()->json($rooms);
        }
        return response()->view('pages.room.index');
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
    public function store(StoreRoomRequest $request)
    {
        $request->validated();

        $room = new Room();
        $room->name = $request->name;
        $room->capacity = $request->capacity;
        $room->description = $request->description;
        $room->save();

        return response()->json([
            'message' => 'Room created successfully',
            'data' => $room,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Room $room)
    {
        if ($request->ajax()) {
            return response()->json($room);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $request->validated();

        $room->name = $request->name;
        $room->capacity = $request->capacity;
        $room->description = $request->description;
        $room->save();

        return response()->json([
            'message' => 'Room updated successfully',
            'data' => $room,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Room $room)
    {
        $room->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Room deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
