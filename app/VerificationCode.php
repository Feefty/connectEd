<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $table = 'verification_codes';
    protected $fillable = ['code', 'created_at', 'updated_at', 'school_id', 'status', 'group_id'];

    public function group()
    {
    	return $this->belongsTo('\App\Group');
    }

    public function school()
    {
    	return $this->belongsTo('\App\School');
    }
}
