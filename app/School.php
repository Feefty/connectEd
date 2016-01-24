<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
   	protected $table = 'schools';
   	protected $fillable = ['name', 'description', 'address', 'created_at', 'updated_at', 'logo', 'motto', 'mission', 'vision', 'website', 'contact_no', 'goal'];

   	public function member()
   	{
   		return $this->hasMany('\App\SchoolMember');
   	}

   	public function exam()
   	{
   		return $this->hasMany('\App\Exam');
   	}

      public function lesson()
      {
         return $this->hasMany('\App\Lesson');
      }

      public function class_section()
      {
         return $this->hasMany('\App\ClassSection');
      }
}
