<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
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

    public function index()
    {
        $users = User::sorted();

        return view('admin.users')
            ->with('users', $users);
    }
}