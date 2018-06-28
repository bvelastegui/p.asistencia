<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkDay extends Model
{
    protected $fillable = [
        'subject_id', 'theme', 'start', 'end', 'date'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
