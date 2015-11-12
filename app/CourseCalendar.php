<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCalendar extends Model
{
    protected $table = 'course_calendar';
    protected $fillable = ['title', 'date', 'description', 'created_by', 'created_at', 'updated_at'];
}
