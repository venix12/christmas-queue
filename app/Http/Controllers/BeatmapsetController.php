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

        $apiBeatmaps = OsuApi::getBeatmapset($request->beatmapsetId);

        if (count($apiBeatmaps) === 0) {
            return response()->json(['error' => 'Beatmapset not found... Make sure you put correct beatamapset ID!']);
        }

        $modes = [false, false, false, false];

        foreach ($apiBeatmaps as $beatmap) {
            $modes[$beatmap->mode] = true;
        }

        $mapset = Mapset::create([
            'user_id' => Auth::id(),
            'osu_user_id' => $apiBeatmaps[0]->creator_id,
            'beatmapset_artist' => $apiBeatmaps[0]->artist,
            'beatmapset_creator' => $apiBeatmaps[0]->creator,
            'beatmapset_osu_id' => $request->beatmapsetId,
            'beatmapset_title' => $apiBeatmaps[0]->title,
            'osu' => $modes[0],
            'taiko' => $modes[1],
            'catch' => $modes[2],
            'mania' => $modes[3],
        ]);

        return response()->json($mapset);
    }
}
