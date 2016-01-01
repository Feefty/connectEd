<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $fillable = ['name', 'code', 'description', 'created_at', 'updated_at'];

    public function exam()
    {
    	return $this->hasMany('\App\Exam');
    }
}
