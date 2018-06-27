<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Course course
 */
class Student extends Model
{
    protected $fillable = [
        'name', 'lastName', 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subjects()
    {
        return $this->course->subjects();
    }
}
