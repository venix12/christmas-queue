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

        $alreadyDeleted = count($maps->where('deleted', 1)->where('beatmapset_osu_id', $request->beatmapsetId));
        $notApproved = count($maps->where('deleted', 0)->where('approved', 0)->where('user_id', Auth::id()));

        if($notApproved < 1)
        {
            if($alreadyDeleted < 1)
            {
                $mapset = Mapset::create([
                    'user_id' => Auth::id(),
                    'osu_user_id' => $request->osuUserId,
                    'beatmapset_artist' => $request->beatmapsetArtist,
                    'beatmapset_creator' => $request->beatmapsetCreator,
                    'beatmapset_osu_id' => $request->beatmapsetId,
                    'beatmapset_title' => $request->beatmapsetTitle,
                    'osu' => in_array('osu', $request->modes) ? true : false,
                    'taiko' => in_array('taiko', $request->modes) ? true : false,
                    'catch' => in_array('catch', $request->modes) ? true : false,
                    'mania' => in_array('mania', $request->modes) ? true : false
                ]);
            } else {
                $mapset = ['error' => 'This beatmap was already refused!'];
            }
        } else {
            $mapset = ['error' => 'You already requested a beatmap awaiting approval!'];
        }

        return response()->json($mapset);
    }
}
