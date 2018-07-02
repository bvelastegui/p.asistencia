<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attendance
 * @package App
 * @method Collection getAttendances(int $subject, Carbon $date)
 */
class Attendance extends Model
{
    protected $fillable = [
        'status', 'student_id', 'work_day_id'
    ];

    public function workDay()
    {
        return $this->belongsTo(WorkDay::class);
    }

    public function scopeGetAttendances(Builder $query, $subject, Carbon $date)
    {
        return $query->whereHas('workDay', function (Builder $query) use ($subject, $date) {
            $query->where('subject_id', $subject)->where('date', $date->format('Y-m-d'));
        })->get();
    }
}
