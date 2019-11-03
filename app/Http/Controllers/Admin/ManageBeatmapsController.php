<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Mapset;
use Illuminate\Http\Request;

class ManageBeatmapsController extends Controller
{
    public function approve(Request $request)
    {
        $beatmap = Mapset::find($request->beatmap_id);
        $beatmap->approved = true;
        $beatmap->deleted = false;
        $beatmap->save();
    }

    public function delete(Request $request)
    {
        $beatmap = Mapset::find($request->beatmap_id);
        $beatmap->approved = false;
        $beatmap->deleted = true;
        $beatmap->save();
    }

    public function index()
    {
        $beatmapsDeleted = mapset::where('deleted', 1)->get();
        $beatmapsNotApproved = Mapset::where('deleted', 0)->where('approved', 0)->get();

        return view('admin.beatmaps')
            ->with('beatmapsDeleted', $beatmapsDeleted)
            ->with('beatmapsNotApproved', $beatmapsNotApproved);
    }

    public function restore(Request $request)
    {
        $beatmap = Mapset::find($request->beatmap_id);
        $beatmap->approved = true;
        $beatmap->deleted = false;
        $beatmap->save();
    }
}
