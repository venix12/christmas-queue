<?php

namespace App\Http\Controllers;

use Auth;
use App\Mapset;
use Illuminate\Http\Request;

class BeatmapsetController extends Controller
{

    public function index()
    {
        $maps = Mapset::all();
        return response()->json($maps);
    }

    public function store(Request $request)
    {

        $mapset = Mapset::create([
            'user_id' => Auth::id(),
            'osu_user_id' => $request->osuUserId,
            'beatmapset_artist' => $request->beatmapsetArtist,
            'beatmapset_creator' => $request->beatmapsetCreator,
            'beatmapset_osu_id' => $request->beatmapsetId,
            'beatmapset_title' => $request->beatmapsetTitle,
        ]);

        return $mapset->toJson();
    }
}
