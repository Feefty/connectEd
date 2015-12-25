<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    protected $table = 'class_subjects';
    protected $fillable = ['class_section_id', 'subject_id', 'room', 'teacher_id', 'created_at', 'updated_at'];

    public function schedule()
    {
    	return $this->hasMany('\App\SubjectSchedule', 'class_subject_id');
    }
}
