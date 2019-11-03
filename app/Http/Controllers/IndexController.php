<?php

namespace App\Http\Controllers;

use App\Mapset;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $beatmaps = Mapset::where('approved', 1)->where('deleted', 0)->get();

        return view('welcome')
            ->with('beatmaps', $beatmaps);
    }
}
