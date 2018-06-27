<?php

namespace App\Http\Controllers;

use App\Course;
use App\Schedule;
use App\Student;
use App\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role == 'admin') {
            $courses = Course::all();
        } else {
            $courses = Course::whereUserId($request->user()->id)->get();
        }

        return new JsonResponse($courses);
    }

    public function students($courseId)
    {
        $students = Student::whereCourseId($courseId)->get();

        return new JsonResponse($students);
    }

    public function subjects($courseId)
    {
        $subjects = Subject::whereCourseId($courseId)->get();

        return new JsonResponse($subjects);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:6',
            'level' => 'required'
        ]);

        $newCourse = Course::create([
            'name' => $request->get('name'),
            'level' => $request->get('level')
        ]);

        return redirect()->route('home', ['course' => $newCourse->id]);
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
}
