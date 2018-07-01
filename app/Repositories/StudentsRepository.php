<?php

namespace App\Repositories;


use App\Student;

class StudentsRepository
{
    protected $model;

    public function __construct(Student $student)
    {
        $this->model = $student;
    }

    public function byCourse($course_id)
    {
        return $this->model->whereCourseId($course_id)->get();
    }
}