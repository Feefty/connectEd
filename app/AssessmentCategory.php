<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentCategory extends Model
{
    protected $table = 'assessment_categories';
    protected $fillable = ['name', 'description', 'created_at', 'updated_at'];

    public function assessment()
    {
    	return $this->hasMany('\App\Assessment');
    }

    public function grade_component()
    {
    	return $this->hasMany('\App\GradeComponent');
    }
}
