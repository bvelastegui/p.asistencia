<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 * @property-read Student[] students
 */
class Course extends Model
{
    protected $fillable = [
        'name', 'level', 'code', 'period'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'course_id', 'id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
