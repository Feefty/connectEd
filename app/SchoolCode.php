<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolCode extends Model
{
    protected $table = 'school_codes';
    protected $fillable = ['code', 'created_at', 'updated_at', 'school_id', 'status', 'group_id'];
}
