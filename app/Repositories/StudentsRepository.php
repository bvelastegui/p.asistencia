<?php
/**
 * Created by PhpStorm.
 * User: bvelastegui
 * Date: 6/27/18
 * Time: 2:48 p.m.
 */

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