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
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::all();
        $courseId = $request->get('course', null);
        $activeTab = $request->get('tab', 'default');

        return view('course.index', compact('courses', 'courseId', 'activeTab'));
    }

    public function update(Request $request, Course $course)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|min:6',
                'level' => 'required',
                'period' => 'required',
                'code' => ['required', Rule::unique('courses')->ignore($course->code, 'code')],
            ],
            [
                'code.unique' => 'El ID de curso ya fue utilizado, por favor, cambie el ID de curso.',
            ]
        );

        $course->update($request->only('name', 'level', 'period', 'code'));

        return redirect()->route('courses.index', ['course' => $course->id])->with(
            'success',
            'Los cambios fueron registrados con éxito.'
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:6',
                'level' => 'required',
                'period' => 'required',
                'code' => 'required|unique:courses,code',
            ],
            [
                'code.unique' => 'El ID de curso ya fue utilizado, por favor, cambie el ID de curso.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error1', true)->withErrors($validator)->withInput();
        }

        $newCourse = Course::create(
            [
                'name' => $request->get('name'),
                'level' => $request->get('level'),
                'code' => $request->get('code'),
                'period' => $request->get('period'),
            ]
        );

        return redirect()->route('courses.index', ['course' => $newCourse->id])->with(
            'success',
            'Los cambios se registraron con éxito'
        );
    }

    public function storeStudents(Request $request, $courseId)
    {

        $this->validate($request, ['name' => 'required', 'lastName' => 'required']);

        Student::create(
            [
                'name' => $request->get('name'),
                'lastName' => $request->get('lastName'),
                'course_id' => $courseId,
            ]
        );

        return redirect()->route('home', ['course' => $courseId, 'tab' => 'students'])->with(
            'success',
            'El estudiante fue agregado con éxito.'
        );
    }

    public function storeSubjects(Request $request, $courseId)
    {
        $this->validate($request, ['name' => 'required|min:6', 'teacher' => 'required|exists:users,id']);

        Subject::create(
            [
                'name' => $request->get('name'),
                'course_id' => $courseId,
                'user_id' => $request->get('teacher'),
            ]
        );

        return redirect()->route('home', ['course' => $courseId, 'tab' => 'subjects'])->with(
            'success',
            'La materia fue agregada con éxito.'
        );
    }

    public function storeClassSchedule(Request $request, $courseId)
    {
        $this->validate(
            $request,
            [
                'day' => 'required',
                'subject' => 'required',
                'start' => 'required',
                'end' => 'required',
            ]
        );

        Schedule::create(
            [
                'course_id' => $courseId,
                'day' => $request->get('day'),
                'subject_id' => $request->get('subject'),
                'start' => $request->get('start'),
                'end' => $request->get('end'),
            ]
        );


        return redirect()->route('home', ['course' => $courseId, 'tab' => 'classSchedule'])->with(
            'success',
            'La hora de clase fue agregada con éxito.'
        );
    }

    public function deleteClassSchedule(Request $request, $courseId)
    {
        $this->validate(
            $request,
            [
                'schedule' => 'required|exists:schedules,id',
            ]
        );

        Schedule::destroy($request->get('schedule'));

        return redirect()->route('courses.index', ['course' => $courseId, 'tab' => 'classSchedule'])->with(
            'success',
            'La hora de clase fue eliminada con éxito'
        );
    }

    public function updateStudents(Request $request, $courseId)
    {
        if ($request->has('active')) {
            Student::where('id', $request->get('id'))->update(
                [
                    'active' => $request->get('active'),
                ]
            );

            return redirect()->route('courses.index', ['course' => $courseId, 'tab' => 'students']);
        }

        $this->validate(
            $request,
            [
                'name' => 'required',
                'last_name' => 'required',
            ]
        );

        Student::where('id', $request->get('id'))->update($request->only('name', 'last_name'));

        return redirect()->route('courses.index', ['course' => $courseId, 'tab' => 'students'])->with(
            'success',
            'Los cambios fueron registrados con éxito.'
        );
    }

    public function updateSubjects(Request $request, $courseId)
    {
        if ($request->has('active')) {
            Subject::where('id', $request->get('id'))->update(
                [
                    'active' => $request->get('active'),
                ]
            );

            return redirect()->route('courses.index', ['course' => $courseId, 'tab' => 'subjects']);
        }

        Subject::where('id', $request->get('id'))->update($request->only('name', 'user_id'));

        return redirect()->route('courses.index', ['course' => $courseId, 'tab' => 'subjects'])->with(
            'success',
            'Los cambios fueron registrados con éxito.'
        );
    }
}
