<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkDay
 * @package App
 * @mixin Builder
 */
class WorkDay extends Model
{
    protected $fillable = [
        'subject_id', 'theme', 'start', 'end', 'date'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
