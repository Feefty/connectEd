<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $table = 'class_schedules';
    protected $fillable = ['class_room_id', 'day', 'time_start', 'time_end', 'created_at', 'updated_at'];
}
