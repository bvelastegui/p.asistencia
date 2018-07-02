<?php

namespace App\Repositories;


use App\Subject;

class SubjectsRepository
{
    protected $model;

    public function __construct(Subject $subject)
    {
        $this->model = $subject;
    }

    public function byCourse($course_id)
    {
        return $this->model->whereCourseId($course_id)->get();
    }

    public function workByDateAndCourse($date, $course)
    {
        $query = $this->model->newModelQuery();

        $query->whereHas('course', function ($query) use ($course) {
            $query->where('id', $course);
        });

        $query->whereHas('workDays', function ($query) use ($date) {
            $query->where('date', $date);
        });

        return $query->get();
    }
}