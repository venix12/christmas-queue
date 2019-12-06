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
        $events = Event::with('User')->orderBy('id', 'desc')->paginate(45);

        return view('admin.log')
            ->with('events', $events);
    }
}
