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
        $maps = Mapset::all();

        $notApproved = count($maps->where('approved', 0)->where('user_id', Auth::id()));

        if($notApproved < 1)
        {
            $mapset = Mapset::create([
                'user_id' => Auth::id(),
                'osu_user_id' => $request->osuUserId,
                'beatmapset_artist' => $request->beatmapsetArtist,
                'beatmapset_creator' => $request->beatmapsetCreator,
                'beatmapset_osu_id' => $request->beatmapsetId,
                'beatmapset_title' => $request->beatmapsetTitle,
            ]);
        } else {
            $mapset = ['error' => 'You already requested a map awaiting approval!'];
        }

        return response()->json($mapset);
    }
}
