<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolMember extends Model
{
    protected $table = 'school_members';
    protected $fillable = ['user_id', 'school_id', 'level', 'created_at', 'updated_at', 'status', 'code', 'school_code_id'];

    public function school()
    {
    	return $this->belongsTo('\App\School');
    }

    public function user()
    {
    	return $this->belongsTo('\App\User');
    }

    public function school_code()
    {
    	return $this->belongsTo('\App\SchoolCode');
    }
}
