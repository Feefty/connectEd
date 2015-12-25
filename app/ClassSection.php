<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    protected $table = 'class_sections';
    protected $fillable = ['name', 'adviser_id', 'school_id', 'created_at', 'updated_at', 'level', 'year', 'status'];

    public function subject()
    {
    	return $this->hasMany('\App\ClassSubject', 'class_section_id');
    }

    public function student()
    {
    	return $this->hasMany('\App\ClassStudent', 'class_section_id');
    }
}