<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 * @package App
 * @mixin Builder
 */
class Schedule extends Model
{
    protected $fillable = [
        'subject_id', 'start', 'end', 'day'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
