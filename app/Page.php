<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $fillable = ['title', 'content', 'privacy', 'category', 'school_id', 'updated_by', 'created_at', 'updated_at'];

    public function school()
    {
    	return $this->belongsTo('\App\School');
    }

    public function user()
    {
    	return $this->belongsTo('\App\User', 'updated_by');
    }
}
