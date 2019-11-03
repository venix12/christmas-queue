<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Mapset;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test_user()
    {
        $user = User::where('username', 'Venix')->first();

        if ($user === null)
        {
            $user = new User();
            $user->username = 'Venix';
            $user->osu_id = 5999631;
            $user->isAmbassador = true;
            $user->save();
        }

        Auth::login($user);

        return redirect()->back();
    }
}
