<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'lessons';
    protected $fillable = ['title', 'content', 'created_at', 'updated_at', 'posted_by', 'subject_id', 'school_id'];

    public function user()
    {
    	return $this->belongsTo('\App\User', 'posted_by');
    }

    public function file()
    {
    	return $this->hasMany('\App\LessonFile', 'lesson_id');
    }

    public function subject()
    {
        return $this->belongsTo('\App\Subject');
    }

    public function school()
    {
        return $this->belongsTo('\App\School');
    }
}
