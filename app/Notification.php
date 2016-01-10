<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['target_id', 'subject', 'content', 'created_at', 'url'];
    public $timestamps = false;

    public function target()
    {
    	return $this->belongsTo('\App\User', 'target_id');
    }
}
