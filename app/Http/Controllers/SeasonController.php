<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Http\Requests\StoreSeasonRequest;
use App\Http\Requests\UpdateSeasonRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeasonController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Season::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse | Response
    {
        if ($request->ajax()) {
            $seasons = Season::query();
            // $seasons = $seasons->with(["user"]);

            // cari id
            $s_id = $request->input('s_id', '');
            if ($s_id) {
                $seasons = $seasons->where('id', $s_id);
            }
            
            // cari nama
            $s_name = $request->input('s_name', '');
            if ($s_name) {
                $seasons = $seasons->where('name', 'like', '%' . $s_name . '%');
            }

            // urutkan
            $s_sortBy = $request->input('s_sort_by', 'id');
            $s_sortDirection = $request->input('s_sort_direction', 'desc');
            $seasons = $seasons->orderBy($s_sortBy, $s_sortDirection);

            $perPage = $request->input('per_page', 10);
            $seasons = $seasons->paginate($perPage);

            return response()->json($seasons);
        }

        return response()->view('pages.season.index');
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
    public function store(StoreSeasonRequest $request)
    {
        $request->validated();

        $season = new Season();
        $season->name = $request->name;
        $season->start_date = $request->start_date;
        $season->end_date = $request->end_date;
        $season->save();

        return response()->json([
            'message' => 'Season created successfully',
            'data' => $season,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Season $season)
    {
        if ($request->ajax()) {
            // $season = Season::where('id', $season->id)->first();
            return response()->json($season);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeasonRequest $request, Season $season)
    {
        $request->validated();

        $season->name = $request->name;
        $season->start_date = $request->start_date;
        $season->end_date = $request->end_date;
        $season->save();

        return response()->json([
            'message' => 'Season updated successfully',
            'data' => $season,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Season $season)
    {
        $season->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Season deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}
