<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubjectExamUser extends Model
{
    protected $table = 'class_subject_exam_users';
    protected $fillable = ['user_id', 'class_subject_exam_id'];

    public function user()
    {
    	return $this->belongsTo('\App\User');
    }

    public function class_subject_exam()
    {
    	return $this->belongsTo('\App\ClassSubjectExam');
    }
}
