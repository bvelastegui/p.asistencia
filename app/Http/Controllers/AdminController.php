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

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $courses = Course::count();
        $users = User::count();
        $students = Student::count();
        $subjects = Subject::count();
        $schedules = Schedule::selectRaw(DB::raw('SUM(HOUR(TIMEDIFF(start, end))) as hours_per_subject'))->groupBy('subject_id')->get();
        $hours = WorkDay::selectRaw(DB::raw('SUM(HOUR(TIMEDIFF(start, end))) as hours_reported'))->first();
        return view('admin.index', compact('courses', 'users', 'students', 'subjects', 'schedules', 'hours'));
    }
}
