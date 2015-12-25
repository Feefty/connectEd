<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubjectExam extends Model
{
    protected $table = 'class_subject_exams';
    protected $fillable = ['created_at', 'class_subject_id', 'exam_id'];
    public $timestamps = false;
}
