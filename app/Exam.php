<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    protected $fillable = ['title', 'created_by', 'created_at', 'updated_at', 'assessment_category_id', 'school_id', 'subject_id', 'exam_type_id'];

    public function author()
    {
        return $this->belongsTo('\App\User', 'created_by');
    }

    public function question()
    {
    	return $this->hasMany('\App\ExamQuestion', 'exam_id');
    }

    public function assessment_category()
    {
    	return $this->belongsTo('\App\AssessmentCategory');
    }

    public function subject()
    {
    	return $this->belongsTo('\App\Subject');
    }

    public function school()
    {
        return $this->belongsTo('\App\School');
    }

    public function class_subject_exam()
    {
        return $this->hasOne('\App\ClassSubjectExam');
    }

    public function exam_type()
    {
        return $this->belongsTo('\App\ExamType');
    }
}
