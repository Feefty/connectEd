<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubjectExam extends Model
{
    protected $table = 'class_subject_exams';
    protected $fillable = ['created_at', 'class_subject_id', 'exam_id', 'start', 'end', 'quarter'];
    public $timestamps = false;

    public function exam()
    {
    	return $this->belongsTo('\App\Exam');
    }

    public function class_subject()
    {
    	return $this->belongsTo('\App\ClassSubject');
    }

    public function class_subject_exam_user()
    {
        return $this->hasMany('\App\ClassSubjectExamUser');
    }

    public function assessment()
    {
        return $this->hasMany('\App\Assessment');
    }
}
