<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonFile extends Model
{
    protected $table = 'lesson_files';
    protected $fillable = ['name', 'file_name', 'created_at', 'updated_at', 'added_by', 'lesson_id'];

    public function lesson()
    {
    	return $this->belongsTo('\App\Lesson');
    }

    public function user()
    {
    	return $this->belongsTo('\App\User', 'added_by');
    }
}
