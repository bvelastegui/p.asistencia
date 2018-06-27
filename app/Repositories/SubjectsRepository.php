<?php
/**
 * Created by PhpStorm.
 * User: bvelastegui
 * Date: 6/27/18
 * Time: 3:12 p.m.
 */

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