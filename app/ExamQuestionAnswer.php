<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamQuestionAnswer extends Model
{
    protected $table = 'exam_question_answers';
    protected $fillable = ['answer', 'points', 'created_at', 'updated_at', 'exam_question_id'];
}
