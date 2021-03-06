<?php


namespace App\Repositories;


use App\Schedule;

class SchedulesRepository
{
    protected $model;

    public function __construct(Schedule $schedule)
    {
        $this->model = $schedule;
    }

    public function byCourseAndDay($courseId, $day)
    {
        return $this->model->whereHas('subject', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->where('day', $day)
            ->orderBy('start')
            ->get();
    }
}