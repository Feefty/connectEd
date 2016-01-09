<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $table = 'assessments';
    protected $fillable = ['score', 'total', 'source', 'class_subject_exam_id', 'term', 'status', 'class_student_id', 'class_subject_id'];


    public function student()
    {
    	return $this->belongsTo('\App\ClassStudent');
    }

    public function class_subject()
    {
        return $this->belongsTo('\App\ClassSubject');
    }

    public function class_subject_exam()
    {
    	return $this->belongsTo('\App\ClassSubjectExam');
    }
}
