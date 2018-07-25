<?php

namespace App\Http\Controllers;

use App\Course;
use App\Exports\DefaultExport;
use App\Schedule;
use App\WorkDay;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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

        $info = $this->_getInfo($start, $end);

        return view('reports.show', compact('start', 'end', 'info'));
    }

    /**
     * @param $start
     * @param $end
     * @return Collection
     */
    public function _getInfo($start, $end): Collection
    {
        $teachers = DB::select("SELECT
  u.identity,
  u.id,
  u.name,
  SUM(TIMESTAMPDIFF(MINUTE, sc.start, sc.end)) as minutes_to_work,
  (SELECT SUM(TIMESTAMPDIFF(WEEK, ?, ?)))      as weeks
FROM schedules sc
  INNER JOIN subjects sub ON sc.subject_id = sub.id
  INNER JOIN users u on sub.user_id = u.id
GROUP BY u.id", [$start, $end]);

        return collect($teachers)->each(function ($item) use ($start, $end) {
            $item->total_time = $this->_minutesToHours(($item->minutes_to_work * $item->weeks));
            $time = DB::select("SELECT SUM(TIMESTAMPDIFF(MINUTE, work_days.start, work_days.end)) as minutes_worked
FROM work_days
  INNER JOIN subjects ON subject_id = subjects.id
  INNER JOIN users u on subjects.user_id = u.id
WHERE u.id = ? AND date between ? AND ?
GROUP BY u.id", [$item->id, $start, $end]);
            $item->minutes_worked = $time[0]->minutes_worked ?? 0;
            $item->real_time = $time ? $this->_minutesToHours($time[0]->minutes_worked) : 0;

            return $item;
        });
    }

    public function _minutesToHours($min)
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

    public function generate(Request $request)
    {
        $case = $request->get('type', null);
        $data = $request->only('users', 'type', 'fecha');
        switch ($case) {
            case 'pdf':
                return \PDF::loadView('reports.pdf', $data)->download('reporte.pdf');
            case 'xlsx':
                return \Excel::download(new DefaultExport($data), 'reporte.xlsx');
        }
    }
}
