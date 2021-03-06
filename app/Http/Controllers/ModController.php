<?php

namespace App\Http\Controllers;

use Auth;
use App\Mod;
use Illuminate\Http\Request;

class ModController extends Controller
{
    public function store(Request $request)
    {
        $userMod = Mod::where('mapset_id', $request->beatmap_id)
            ->where('type', $request->type)
            ->where('user_id', Auth::id())
            ->first();

        if($userMod === null)
        {
            $createMod = Mod::create([
                'mapset_id' => $request->beatmap_id,
                'type' => $request->type,
                'user_id' => Auth::id(),
            ]);

            $response = Mod::with('User')->where('id', $createMod->id)->get();

            return response()->json($response);
        } else {
            $response = 'error';

            return response()->json($response);
        }
    }

    public function remove(Request $request)
    {
        $userMod = Mod::where('mapset_id', $request->beatmap_id)
            ->where('type', $request->type)
            ->where('user_id', Auth::id())
            ->first();

        if($userMod !== null)
        {
            $response = $userMod;
            $userMod->delete();
        } else {
            $response = 'error';
        }

        return response()->json($response);
    }
}
