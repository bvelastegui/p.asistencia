<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = auth()->id();
        $schedules = (new Schedule)->whereHas("subject", function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('subject')->where('day', date('l'))->get();

        return view('subjects.index', compact('schedules'));
    }
}
