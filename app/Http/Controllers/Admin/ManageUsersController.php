<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use App\Mapset;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    public function addUsergroup(Request $request)
    {
        $admins = [654108, 1541323, 5999631];
        $groups = [0, 1, 2];
        $groupNames = ['Modders', 'Nominators', 'Ambassadors'];

        $user = User::where('username', $request->username)->first();

        if($user === null) {
            return redirect()->back()
                ->with('error', 'User not found!');
        }

        if(!in_array($request->group, $groups)) {
            return redirect()->back()
                ->with('error', 'Usergroup not found!');
        }

        switch($request->group) {
            case 0:
                $usergroup = 'isModder';
                break;
            case 1:
                $usergroup = 'isNominator';
                break;
            case 2:
                $usergroup = 'isAmbassador';
                break;
        }

        if($usergroup === 'isAmbassador' && !in_array(Auth::user()->osu_id, $admins))
        {
            return redirect()->back()
                ->with('error', 'You are not permitted to change this usergroup!');
        }

        $user->$usergroup = $user->$usergroup ? false : true;
        $user->save();

        Event::log($user->$usergroup ? 'Moved user '.$user->username.' to the '.$groupNames[$request->group] : 'Removed user '.$user->username.' from the '.$groupNames[$request->group] );

        return redirect()->back()
            ->with('success', 'Successfully changed the usergroup!');
    }

    public function forumExport()
    {
        $modders = User::where('isModder', true)
            ->orderBy('username')
            ->get();

        $bbcode = '';

        foreach (Mapset::MODES as $mode) {
            $moddersForMode = $modders->where($mode, true);

            if ($moddersForMode->count() === 0) {
                continue;
            }

            $modeName = gamemode($mode);
            $bbcode .= "$modeName\n[list]\n";

            foreach ($moddersForMode as $modder) {
                $star = '';

                if ($modder->isNat) {
                    $star = '[color=#FF8F00]*[/color] ';
                } else if ($modder->isNominator) {
                    $star = '[color=#BF40FF]*[/color] ';
                }

                $bbcode .= "[*][profile=$modder->username]$star$modder->username[/profile]\n";
            }

            $bbcode .= "[/list]\n";
        }

        return response($bbcode)->header('Content-Type', 'text/plain');
    }

    public function index()
    {
        $users = User::sorted();

        return view('admin.users')
            ->with('users', $users);
    }

    public function switchGamemode()
    {
        $data = request()->all();

        $mode = $data['gamemode'];
        $user = User::where('username', $data['username'])->first();

        $user->update([
            $mode => $user->$mode ? false : true,
        ]);

        return redirect()->back()
            ->with('success', 'Successfully switched the gamemode!');
    }
}
