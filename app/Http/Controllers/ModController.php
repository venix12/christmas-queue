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

            $mod = [$createMod, 'user' => ['id' => Auth::user()->id, 'username' => Auth::user()->username]];

            return response()->json($mod);
        } else {
            $response = 'error';

            return response()->json($response);
        }
    }
}
