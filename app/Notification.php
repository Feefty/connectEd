<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id', 'title', 'message', 'created_at'];
    public $timestamps = false;
}
