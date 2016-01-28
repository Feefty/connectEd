<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuarterCalendar extends Model
{
    protected $table = 'quarter_calendar';
    protected $fillable = ['quarter', 'date_from', 'date_to', 'school_year'];
}
