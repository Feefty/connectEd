<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeSummary extends Model
{
    protected $table = 'grade_summaries';
    protected $fillable = ['qaurter', 'grade', 'remarks', 'created_at', 'updated_at', 'school_year', 'class_subject_id', 'student_id'];

    public function student()
    {
        return $this->belongsTo('\App\User', 'student_id');
    }

    public function class_subject()
    {
        return $this->belongsTo('\App\ClassSubject');
    }
}
