<?php

namespace App\Http\Controllers;

use Auth;
use App\Mapset;
use Illuminate\Http\Request;
use OsuApi;

class BeatmapsetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function index()
    {
        $maps = Mapset::all();
        return response()->json($maps);
    }

    public function store(Request $request)
    {
        $existingMapset = Mapset::where('beatmapset_osu_id', $request->beatmapsetId)->first();

        if ($existingMapset !== null) {
            $error = $existingMapset->deleted
                ? 'This beatmap was already refused!'
                : 'This beatmap was already requested!';

            return response()->json(['error' => $error]);
        }

        if (Auth::user()->requestedMaps()->where('approved', false)->where('deleted', false)->exists()) {
            return response()->json(['error' => 'You already requested a beatmap awaiting approval!']);
        }

        $mapset = Mapset::createFromOnline($request->beatmapsetId, Auth::user());

        if ($mapset === null) {
            return response()->json(['error' => 'Beatmapset not found... Make sure you put correct beatamapset ID!']);
        }

        return response()->json($mapset);
    }
}
