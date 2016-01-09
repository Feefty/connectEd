<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    protected $table = 'class_sections';
    protected $fillable = ['name', 'adviser_id', 'school_id', 'created_at', 'updated_at', 'level', 'year', 'status'];

    public function subject()
    {
    	return $this->hasMany('\App\ClassSubject');
    }

    public function student()
    {
    	return $this->hasMany('\App\ClassStudent');
    }

    public function school()
    {
        return $this->belongsTo('\App\School');
    }

    public function teacher()
    {
        return $this->belongsTo('\App\User', 'adviser_id');
    }
}