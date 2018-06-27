<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

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
        if ($request->user()->role == 'teacher') {
            return redirect()->route('subjects.index');
        }

        $courses = Course::all();
        $courseId = $request->get('course', null);
        $activeTab = $request->get('tab', 'students');
        return view('home', compact('courses', 'courseId', 'activeTab'));
    }
}
