<?php

namespace App\Http\Controllers;

use App\Mapset;
use Illuminate\Http\Request;

class BeatmapController extends Controller
{
    public function index() {
        $beatmaps = Mapset::where('approved', 1)
            ->where('deleted', 0)
            ->get();

        if (count($beatmaps) >= 8)
        {
            $beatmaps = $beatmaps->random(8);
        }

        return view('welcome')
            ->with('beatmaps', $beatmaps);
    }

    public function beatmaps() {
        $beatmaps = Mapset::where('approved', 1)
            ->where('deleted', 0)
            ->get();

        return view('beatmaps')
            ->with('beatmaps', $beatmaps);
    }
}
