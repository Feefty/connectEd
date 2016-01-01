<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $table = 'exam_questions';
    protected $fillable = ['question', 'created_at', 'updated_at', 'exam_id', 'category', 'time_limit'];

    public function answer()
    {
    	return $this->hasMany('\App\ExamQuestionAnswer', 'exam_question_id');
    }

    public function exam()
    {
    	return $this->belongsTo('\App\Exam');
    }

    public function student_exam_question_answer()
    {
        return $this->hasMany('\App\StudentExamQuestionAnswer');
    }
}
