<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentExamQuestionAnswer extends Model
{
    protected $table = 'student_exam_question_answers';
    protected $fillable = ['answer', 'created_at', 'exam_question_id', 'user_id'];
    public $timestamps = false;
}
