<?php

namespace App\Http\Controllers;

use App\Course;
use App\WorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Course $course)
    {
        $courseId = $course->id;
        $dates = WorkDay::selectRaw(DB::raw("MIN(date) as start_date, MAX(date) as end_date"))->whereHas('subject', function ($query) use ($courseId) {
            $query->whereCourseId($courseId);
        })->first();
        return view('reports.index', compact('course','dates'));
    }
}
