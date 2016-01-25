<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSectionCode extends Model
{
    protected $table = 'class_section_codes';
    protected $fillable = ['code', 'created_at', 'updated_at', 'class_section_id', 'status'];

    public function class_section()
    {
        return $this->belongsTo('\App\ClassSection');
    }
}
