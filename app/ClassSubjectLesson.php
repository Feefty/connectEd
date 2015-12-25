<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubjectLesson extends Model
{
    protected $table = 'class_subject_lessons';
    protected $fillable = ['class_subject_id', 'lesson_id', 'added_by', 'created_at'];
    public $timestamps = false;
}
