<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievements';
    protected $fillable = ['title', 'description', 'created_at', 'updated_at', 'icon'];
}
