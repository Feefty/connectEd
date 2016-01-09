<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $fillable = ['status', 'student_id', 'class_subject_id', 'date'];

    public function student()
    {
    	return $this->belongsTo('\App\User', 'student_id');
    }

    public function class_subject()
    {
    	return $this->belongsTo('\App\ClassSubject');
    }
}
