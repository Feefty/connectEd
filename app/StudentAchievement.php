<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAchievement extends Model
{
    protected $table = 'student_achievements';
    protected $fillable = ['student_id', 'achievement_id', 'created_at', 'updated_at'];

    public function student()
    {
        return $this->belongsTo('\App\User', 'student_id');
    }

    public function achievement()
    {
        return $this->belongsTo('\App\Achievement');
    }
}
