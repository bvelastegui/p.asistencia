<?php

namespace App\Http\Controllers;

use App\Course;
use App\Schedule;
use App\Student;
use App\Subject;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::all();
        $courseId = $request->get('course', null);
        $activeTab = $request->get('tab', 'default');
        return view('course.index', compact('courses', 'courseId', 'activeTab'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6',
            'level' => 'required',
            'period' => 'required',
            'code' => 'required|unique:courses,code'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error1', true)->withErrors($validator)->withInput();
        }

        $newCourse = Course::create([
            'name' => $request->get('name'),
            'level' => $request->get('level'),
            'code' => $request->get('code'),
            'period' => $request->get('period'),
        ]);

        return redirect()->route('courses.index', ['course' => $newCourse->id]);
    }

    public function storeStudents(Request $request, $courseId)
    {

        $this->validate($request, ['name' => 'required', 'lastName' => 'required']);

        Student::create([
            'name' => $request->get('name'),
            'lastName' => $request->get('lastName'),
            'course_id' => $courseId
        ]);

        return redirect()->route('home', ['course' => $courseId, 'tab' => 'students']);
    }

    public function storeSubjects(Request $request, $courseId)
    {
        $this->validate($request, ['name' => 'required|min:6', 'teacher' => 'required|exists:users,id']);

        Subject::create([
            'name' => $request->get('name'),
            'course_id' => $courseId,
            'user_id' => $request->get('teacher')
        ]);

        return redirect()->route('home', ['course' => $courseId, 'tab' => 'subjects']);
    }

    public function storeClassSchedule(Request $request, $courseId)
    {
        $this->validate($request, [
            'day' => 'required',
            'subject' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);

        Schedule::create([
            'course_id' => $courseId,
            'day' => $request->get('day'),
            'subject_id' => $request->get('subject'),
            'start' => $request->get('start'),
            'end' => $request->get('end')
        ]);


        return redirect()->route('home', ['course' => $courseId, 'tab' => 'classSchedule']);
    }

    public function deleteClassSchedule(Request $request, $courseId)
    {
        $this->validate($request, [
            'schedule' => 'required|exists:schedules,id'
        ]);

        Schedule::destroy($request->get('schedule'));

        return redirect()->route('home', ['course' => $courseId, 'tab' => 'classSchedule']);
    }

    public function updateStudents(Request $request, $courseId)
    {
        if ($request->has('active')) {
            Student::where('id', $request->get('id'))->update([
                'active' => $request->get('active')
            ]);

            return redirect()->route('courses.index', ['course' => $courseId, 'tab' => 'students']);
        }

        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required'
        ]);

        Student::where('id', $request->get('id'))->update($request->only('name', 'last_name'));

        return redirect()->route('courses.index', ['course' => $courseId, 'tab' => 'students']);
    }

    public function updateSubjects(Request $request, $courseId)
    {
        if ($request->has('active')) {
            Subject::where('id', $request->get('id'))->update([
                'active' => $request->get('active')
            ]);

            return redirect()->route('courses.index', ['course' => $courseId, 'tab' => 'subjects']);
        }

        Subject::where('id', $request->get('id'))->update($request->only('name', 'user_id'));

        return redirect()->route('courses.index', ['course' => $courseId, 'tab' => 'subjects']);
    }
}
