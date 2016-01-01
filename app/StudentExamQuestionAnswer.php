<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentExamQuestionAnswer extends Model
{
    protected $table = 'student_exam_question_answers';
    protected $fillable = ['answer', 'created_at', 'exam_question_id', 'user_id', 'points', 'time_answered'];
    public $timestamps = false;

    public function exam_question()
    {
    	return $this->belongsTo('\App\ExamQuestion');
    }

    public function user()
    {
    	return $this->belongsTo('\App\User');
    }
}
