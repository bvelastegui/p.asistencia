<?php

namespace App\Http\Controllers;


use App\Schedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = auth()->id();
        $day = env('APP_DEBUG') ? 'Tuesday' : date('l');
        $schedules = (new Schedule)->whereHas("subject", function (Builder $query) use ($userId) {
            $query->select('id')->where('user_id', $userId);
        })->where('day', $day)->get();

        return view('schedules.index', compact('schedules','day'));
    }

    public function edit($scheduleId)
    {

    }

    public function store()
    {

    }
}