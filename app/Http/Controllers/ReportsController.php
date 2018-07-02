<?php

namespace App\Http\Controllers;

use App\Course;
use App\Repositories\SubjectsRepository;
use App\Schedule;
use App\WorkDay;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Course $course, $date = 'now')
    {
        $now = Carbon::parse(env('APP_DEBUG') ? '2018-06-26' : $date);

        $dates = WorkDay::selectRaw(DB::raw("MIN(date) as start_date, MAX(date) as end_date"))->whereHas('subject', function (Builder $query) use ($course) {
            $query->where('course_id', $course->id);
        })->first();

        $schedules = Schedule::where('day', $now->format('l'))->whereHas('subject', function (Builder $query) use ($course) {
            $query->select('course_id')->where('course_id', $course->id);
        })->get();

        return view('reports.index', compact('course', 'dates', 'now', 'schedules'));
    }
}
