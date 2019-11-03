<?php

namespace App\Http\Controllers\api;

use App\Mod;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModController extends Controller
{
    public function index()
    {
        $mods = Mod::with(['User' => function($query){
            $query->select('id', 'username');
        }])->where('type', 0)->get();

        return response()->json($mods);
    }

    public function show($id)
    {
        $mods = Mod::with(['User' => function($query){
            $query->select('id', 'username');
        }])->where('mapset_id', $id)->where('type', 0)->get();

        return response()->json($mods);
    }

    public function nominatorsIndex()
    {
        $mods = Mod::with(['User' => function($query){
            $query->select('id', 'username');
        }])->where('type', 1)->get();

        return response()->json($mods);
    }

    public function nominatorsShow($id)
    {
        $mods = Mod::with(['User' => function($query){
            $query->select('id', 'username');
        }])->where('mapset_id', $id)->where('type', 0)->get();

        return response()->json($mods);
    }
}