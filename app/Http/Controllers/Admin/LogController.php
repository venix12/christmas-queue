<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $events = Event::with('User')->get();

        return view('admin.log')
            ->with('events', $events);
    }
}
