<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\WorkDay;
use Illuminate\Http\Request;

class WorkDayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($date, $subject)
    {
        $workDayQuery = WorkDay::where('date', $date)->where('subject_id', $subject);
        $workDay = $workDayQuery->exists() ? $workDayQuery->first() : new WorkDay(['subject_id' => $subject, 'date' => $date]);
        return view('workDays.edit', compact('workDay'));

    }

    public function store(Request $request, $date, $subject)
    {
        $this->validate(
            $request,
            ['theme' => 'required', 'start' => 'required'],
            [
                'theme.required' => __('The theme is required'),
                'start.required' => __('Must record the start time')
            ]
        );
        $workDay = new WorkDay();
        $workDay->date = $date;
        $workDay->theme = $request->get('theme');
        $workDay->subject_id = $subject;
        $workDay->start = date('H:i:s');
        $workDay->save();

        foreach ($request->post('attendances') as $student_id => $status) {
            Attendance::create([
                'work_day_id' => $workDay->id,
                'status' => $status,
                'student_id' => $student_id
            ]);
        }

        return redirect()->route('workDays.edit', ['date' => $date, 'subject' => $subject])->with('success', 'Los cambios se registraron con exito!');
    }


    public function update(Request $request, $date, $subject)
    {
        $this->validate(
            $request,
            ['workDayId' => 'required']
        );

        if ($request->has('end')) {
            WorkDay::find($request->get('workDayId'))->update(['end' => date('H:i:s')]);
        }

        foreach ($request->post('attendances') as $student_id => $status) {
            Attendance::where('work_day_id', $request->post('workDayId'))->where('student_id', $student_id)
                ->update(['status' => $status]);
        }

        return redirect()->route('workDays.edit', ['date' => $date, 'subject' => $subject])->with('success', 'Los cambios se registraron con exito!');
    }
}
