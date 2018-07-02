<?php

namespace App\Http\Controllers;

use App\Course;
use App\Schedule;
use App\Student;
use App\Subject;
use App\User;
use App\WorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->user()->change_password_on_next_login) {
            return redirect()->route('users.changePassword');
        }

        if ($request->user()->role === 'teacher') {
            return redirect()->route('schedules.index');
        }

        $courses = Course::count();
        $users = User::count();
        $students = Student::count();
        $subjects = Subject::count();
        $schedules = Schedule::selectRaw(DB::raw('SUM(HOUR(TIMEDIFF(start, end))) as hours_per_subject'))->groupBy('subject_id')->get();
        $hours = WorkDay::selectRaw(DB::raw('SUM(HOUR(TIMEDIFF(start, end))) as hours_this_month'))->whereRaw(DB::raw('MONTH(date) = MONTH(now())'))->first();
        return view('home', compact('courses', 'users', 'students', 'subjects', 'schedules', 'hours'));
    }
}
