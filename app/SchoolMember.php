<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolMember extends Model
{
    protected $table = 'school_members';
    protected $fillable = ['user_id', 'school_id', 'level', 'created_at', 'updated_at', 'status', 'code', 'school_code_id'];
}
