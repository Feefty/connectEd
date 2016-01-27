<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $table = 'student_parents';
    protected $fillable = ['student_id', 'parent_id'];

    public function student()
    {
        return $this->belongsTo('\App\User', 'student_id');
    }

    public function parent()
    {
        return $this->belongsTo('\App\User', 'parent_id');
    }
}
