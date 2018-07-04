<?php

namespace App\Http\Controllers;


use App\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = auth()->id();
        $day = date('l');
        $schedules = (new Schedule)->whereHas("subject", function (Builder $query) use ($userId) {
            $query->select('id')->where('user_id', $userId);
        })->where('day', $day)->get();

        $selected_date = $request->get('date', Carbon::now()->subDay()->format('Y-m-d'));

        $lastSchedules = Schedule::whereHas('subject', function ($query) use ($selected_date, $userId) {
            $query->where('user_id', $userId);
            $query->whereHas('workDays', function ($query) use ($selected_date) {
                $query->where('date', $selected_date)->limit(1);
            });
        })->get();

        return view('schedules.index', compact('schedules', 'day', 'lastSchedules', 'selected_date'));
    }

    public function edit($scheduleId)
    {

    }

    public function store()
    {

    }
}