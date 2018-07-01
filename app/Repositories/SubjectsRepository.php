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
}