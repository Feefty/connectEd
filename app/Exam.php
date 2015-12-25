<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    protected $fillable = ['title', 'start', 'end', 'created_by', 'created_at', 'updated_at', 'exam_type_id', 'school_id', 'subject_id'];

    public function question()
    {
    	return $this->hasMany('\App\ExamQuestion', 'exam_id');
    }

    public function exam_type()
    {
    	return $this->belongsTo('\App\ExamType');
    }

    public function subject()
    {
    	return $this->belongsTo('\App\Subject');
    }
}
