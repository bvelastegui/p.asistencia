<?php

namespace App\Repositories;


use App\Course;

class CoursesRepository
{
    protected $model;

    public function __construct(Course $course)
    {
        $this->model = $course;
    }


    public function workDays($course_id, $date)
    {

    }
}