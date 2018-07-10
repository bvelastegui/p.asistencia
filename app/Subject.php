<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subject
 * @property Course|Builder course
 * @package App
 *
 */
class Subject extends Model
{
    protected $fillable = [
        'name', 'course_id', 'user_id', 'active'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function workDays()
    {
        return $this->hasMany(WorkDay::class);
    }
}
