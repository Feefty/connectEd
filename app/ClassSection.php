<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    protected $table = 'class_sections';
    protected $fillable = ['name', 'adviser_id', 'school_id', 'created_at', 'updated_at', 'level', 'year', 'status'];
}
