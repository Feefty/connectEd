<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCalendar extends Model
{
    protected $table = 'course_calendar';
    protected $fillable = ['title', 'date_from', 'date_to', 'description', 'created_by', 'created_at', 'updated_at', 'class_section_id', 'school_id'];

    public function author()
    {
        return $this->belongsTo('\App\User', 'created_by');
    }

    public function class_section()
    {
        return $this->belongsTo('\App\ClassSection');
    }

    public function school()
    {
        return $this->belongsTo('\App\School');
    }
}
