<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
   	protected $table = 'schools';
   	protected $fillable = ['name', 'description', 'address', 'created_at', 'updated_at'];

   	public function member()
   	{
   		return $this->hasMany('\App\SchoolMember', 'school_id');
   	}

   	public function exam()
   	{
   		return $this->hasMany('\App\Exam', 'school_id');
   	}

      public function lesson()
      {
         return $this->hasMany('\App\Lesson', 'school_id');
      }
}
