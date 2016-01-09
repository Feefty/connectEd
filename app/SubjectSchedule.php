<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectSchedule extends Model
{
    protected $table = 'subject_schedules';
    protected $fillable = ['class_subject_id', 'day', 'time_start', 'time_end', 'created_at', 'updated_at'];

    public function class_subject()
    {
    	return $this->belongsTo('\App\ClassSubject');
    }
}
