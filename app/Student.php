<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Course course
 */
class Student extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'course_id',
        'active'
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
