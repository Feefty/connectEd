<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    protected $table = 'class_subjects';
    protected $fillable = ['class_section_id', 'subject_id', 'room', 'teacher_id', 'created_at', 'updated_at'];

    public function schedule()
    {
    	return $this->hasMany('\App\SubjectSchedule');
    }
    
    public function teacher()
    {
    	return $this->belongsTo('\App\User', 'teacher_id');
    }

    public function class_section()
    {
    	return $this->belongsTo('\App\ClassSection');
    }

    public function subject()
    {
    	return $this->belongsTo('\App\Subject');
    }

    public function class_subject_exam()
    {
        return $this->hasMany('\App\ClassSubjectExam');
    }

    public function subject_schedule()
    {
        return $this->hasMany('\App\SubjectSchedule');
    }
}
