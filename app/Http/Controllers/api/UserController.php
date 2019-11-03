<?php

namespace App\Http\Controllers\api;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function currentUser() {
        $user = Auth::user();

        return response()->json($user);
    }
}