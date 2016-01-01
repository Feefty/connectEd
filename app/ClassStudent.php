<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    protected $table = 'class_students';
    protected $fillable = ['class_section_id', 'student_id', 'created_at', 'updated_at', 'class_section_code_id'];

    public function class_section()
    {
    	return $this->belongsTo('\App\ClassSection');
    }

    public function student()
    {
    	return $this->belongsTo('\App\User', 'student_id');
    }

    public function class_section_code()
    {
    	return $this->belongsTo('\App\ClassSectionCode');
    }
}
