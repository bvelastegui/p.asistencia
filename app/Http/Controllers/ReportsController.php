<?php

namespace App\Http\Controllers;

use App\Course;
use App\Schedule;
use App\User;
use App\WorkDay;
use Carbon\Carbon;
use DebugBar\DebugBar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Course $course, $date = 'now')
    {
        $now = Carbon::parse($date);

        $dates = WorkDay::selectRaw(DB::raw("MIN(date) as start_date, MAX(date) as end_date"))->whereHas('subject', function (Builder $query) use ($course) {
            $query->where('course_id', $course->id);
        })->first();

        $schedules = Schedule::where('day', $now->format('l'))->whereHas('subject', function (Builder $query) use ($course) {
            $query->select('course_id')->where('course_id', $course->id);
        })->get();

        return view('reports.index', compact('course', 'dates', 'now', 'schedules'));
    }

    public function show(Request $request)
    {
        $start = $request->get('start', Carbon::now()->firstOfMonth()->format('Y-m-d'));
        $end = $request->get('end', Carbon::now()->lastOfMonth()->format('Y-m-d'));

        $teachers = DB::select("SELECT
  u.identity,
  u.id,
  u.name,
  SUM(TIMESTAMPDIFF(MINUTE, schedules.start, schedules.end)) as minutes_to_work,
  (SELECT SUM(TIMESTAMPDIFF(WEEK,?,?))) as weeks
FROM schedules
  INNER JOIN subjects ON subject_id = subjects.id
  INNER JOIN users u on subjects.user_id = u.id
GROUP BY u.id", [$start, $end]);

        $info = collect($teachers)->each(function ($item) use ($start, $end) {
            $item->total_time = $this->toHours(($item->minutes_to_work * $item->weeks));
            $time = DB::select("SELECT SUM(TIMESTAMPDIFF(MINUTE, work_days.start, work_days.end)) as minutes_worked FROM work_days INNER JOIN subjects ON subject_id = subjects.id INNER JOIN users u on subjects.user_id = u.id WHERE u.id = ? AND date between ? AND ? GROUP BY u.id", [$item->id, $start, $end]);
            $item->real_time = $time ? $this->toHours($time[0]->minutes_worked) : 0;

            return $item;
        });

        \Debugbar::info($info);

        return view('reports.show', compact('start', 'end', 'info'));
    }

    public function toHours($min)
    {
        $sec = $min * 60;
        $dias = floor($sec / 86400);
        $mod_hora = $sec % 86400;
        $horas = floor($mod_hora / 3600) + ($dias * 24);
        $mod_minuto = $mod_hora % 3600;
        $minutos = floor($mod_minuto / 60);
        if ($horas <= 0) {
            $text = $minutos . ' min';
        } else {
            $text = $horas . "h " . $minutos . 'm';
        }
        return $text;
    }
}
